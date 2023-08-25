<?php

const DB_HOST = "localhost";
const DB_PORT = 3306;
const DB_NAME = "db_beasiswa";
const DB_USER = "root";
const DB_PASS = "";

$pdo = new PDO(
    "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);
