<?php

require __DIR__."/conn.php";

function get_ext(string $fname)
{
    $fname = explode(".", $fname);
    $fname = end($fname);
    return strtolower($fname);
}

function validate_unique_email(string $email): bool
{
    global $pdo; // Akses global variabel di dalam function
    $st = $pdo->prepare("SELECT id FROM tbl_pendaftaran WHERE email = ?");
    $st->execute([$email]);
    return !$st->fetch(PDO::FETCH_ASSOC);
}

function validate_unique_phone(string $phoneNumber): bool
{
    global $pdo;
    $st = $pdo->prepare("SELECT id FROM tbl_pendaftaran WHERE phone = ?");
    $st->execute([$phoneNumber]);
    return !$st->fetch(PDO::FETCH_ASSOC);
}

function validate_input(): bool
{
    $namePat = "/^[a-zA-Z\'\.]{3,}+$/";
    $phonePat = "/^(\+62|08)\d{9,15}$/";
    
    if (!isset($_POST["name"]) || !is_string($_POST["name"])) {
        $err = "The field \"name\" must not be empty and string";
        goto out_err;
    }

    if (!preg_match($namePat, $_POST["name"])) {
        $err = "The field \"name\" must match with the pattern {$namePat}";
        goto out_err;
    }
    
    if (!isset($_POST["email"]) || !is_string($_POST["email"])) {
        $err = "The field \"email\" must not be empty and string";
        goto out_err;
    }

    /**
     * Validasi email
     * 
     * a@ayam.com (VALID)
     * a@ayam (INVALID)
     * asaja@ (INVALID)
     */
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $err = "The email pattern isn't valid";
        goto out_err;
    }
    
    if (!validate_unique_email($_POST["email"])) {
        $err = "The email \"{$_POST["email"]}\" has already been registered, please use another email!";
        goto out_err;
    }

    if (!isset($_POST["phoneNumber"]) || !is_string($_POST["phoneNumber"])) {
        $err = "The field \"phoneNumber\" must not be empty and string";
        goto out_err;
    }

    if (!preg_match($phonePat, $_POST["phoneNumber"])) {
        $err = "The field \"phoneNumber\" must match with the pattern {$phonePat}";
        goto out_err;
    }

    if (!validate_unique_phone($_POST["phoneNumber"])) {
        $err = "The phone number \"{$_POST["phoneNumber"]}\" has already been registered, please use another phone number!";
        goto out_err;
    }
    
    if (!isset($_POST["semester"]) || !is_string($_POST["semester"])) {
        $err = "The field \"semester\" must not be empty and string";
        goto out_err;
    }

    if (!is_numeric($_POST["semester"])) {
        $err = "The field \"semester\" must be numeric";
        goto out_err;
    }

    $semester = (int)$_POST["semester"];
    if ($semester < 1 || $semester > 8) {
        $err = "The field \"semester\" must be an integer within range [1, 8]";
        goto out_err;
    }

    if (!isset($_POST["gpa"]) || !is_string($_POST["gpa"])) {
        $err = "The field \"gpa\" must not be empty and string";
		goto out_err;
    }

    if (!is_numeric($_POST["gpa"])) {
        $err = "The field \"gpa\" must be numeric";
        goto out_err;
    }

    $gpa = (float)$_POST["gpa"];
    if ($gpa < 3 || $gpa > 4) {
        $err = "The field \"gpa\" must be an float within range [3, 4]";
        goto out_err;
    }

    if (!isset($_POST["scholarship"]) || !is_string($_POST["scholarship"])) {
        $err = "The field \"scholarship\" must not be empty and string";
        goto out_err;
    }

    $possibleScolarships = [
        "Akademik",
        "Non-Akademik"
    ];
    if (!in_array($_POST["scholarship"], $possibleScolarships)) {
        $err = "The field \"scholarship\" must be in ".json_encode($possibleScolarships);
        goto out_err;
    }

    if (!isset($_FILES["file"]["name"])) {
        $err = "The field \"file\" must not be empty";
        goto out_err;
    }

    $ext = get_ext($_FILES["file"]["name"]); // Ambil ekstensi file yang mau di upload
    $allowedFileExts = ["png", "jpg", "jpeg", "zip", "pdf"];

    // Cek ekstensi sesuai dgn di allowed
    if (!in_array($ext, $allowedFileExts)) {
        $err = "The file extension must be in ".json_encode($allowedFileExts);
        goto out_err;
    }

    $maxAllowedSize = 2*1024*1024;
    if ($_FILES["file"]["size"] > $maxAllowedSize) {
        $err = "The file size cannot be bigger than 2 MiB";
        goto out_err;
    }

    return true;

out_err:
    http_response_code(400);
    throw new Exception(json_encode(["status" => 400, "msg" => $err]), 400);
}

function save_uploaded_file(): ?string
{
    $filename = $_FILES['file']['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $name = md5($filename.time().rand()).".{$ext}";
    $location = "upload/{$name}";

    if (move_uploaded_file($_FILES['file']['tmp_name'], $location))
        return $name;
    return NULL;
}

const INSERT_QUERY = <<<SQL
    INSERT INTO `tbl_pendaftaran`
    (`name`, `email`, `phone`, `semester`, `gpa`, `type`, `file`)
    VALUES
    (?, ?, ?, ?, ?, ?, ?);
SQL;

function insert_to_database()
{
    global $pdo;

    $file_name = save_uploaded_file();
    if (!$file_name) {
        http_response_code(500);
        echo json_encode(["status" => 500, "msg" => "Failed to save the uploaded file!"]);
        return false;
    }

    try {
        $st = $pdo->prepare(INSERT_QUERY);
        $st->execute([
            $_POST["name"],
            $_POST["email"],
            $_POST["phoneNumber"],
            $_POST["semester"],
            $_POST["gpa"],
            $_POST["scholarship"],
            $file_name
        ]);
        return true;
    } catch (PDOException $e) {
        http_response_code(500);
        @unlink("upload/{$file_name}");
        throw new Exception(json_encode(["status" => 500, "msg" => $e->getMessage()]), 500);
    }
}

function main()
{
    global $pdo;
    header("Content-Type: application/json");

    try {
        $pdo->beginTransaction();
        validate_input();
        insert_to_database();
        $pdo->commit();
        http_response_code(200);
        echo json_encode(["status" => 200, "msg" => "Success!"]);
    } catch (Exception $e) {
        $pdo->rollback();
        http_response_code($e->getCode());
        echo $e->getMessage();
    } catch (PDOException $e) {
        $pdo->rollback();
        http_response_code(500);
        echo json_encode(["status" => 500, "msg" => $e->getMessage()]);
    }
}

main();
