<?php

require __DIR__."/conn.php";

header("Content-Type: application/json");
try {
    http_response_code(200);
    $st = $pdo->prepare("SELECT * FROM tbl_pendaftaran");
    $st->execute();
    echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $ex) {
    http_response_code(500);
    throw new Exception(json_encode(["status" => 500, "msg" => $ex->getMessage()]), 500);
}
