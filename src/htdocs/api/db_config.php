<?php
header('Access-Control-Allow-Origin: *');
$hostname   = '127.0.0.1';
$username   = 'root';
$password   = '';
$database   = 'toko_batik';
$charset    = 'utf8';
$dsn = "mysql:host=$hostname;port=3306;dbname=$database;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $username, $password, $opt);
