<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json; charset=UTF-8');

include 'db_config.php';

$data = json_decode(file_get_contents("php://input"));
$aksi = $data->aksi ?? '';

try {
    switch ($aksi) {
        case 'tampil':
            $stmt = $pdo->prepare("SELECT * FROM produk ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
            break;

        case 'tambah':
            $stmt = $pdo->prepare("INSERT INTO produk (jenis, harga, stok, warna, bahan, kategori, ukuran) 
                                   VALUES (:jenis, :harga, :stok, :warna, :bahan, :kategori, :ukuran)");
            $stmt->bindParam(':jenis', $data->jenis);
            $stmt->bindParam(':harga', $data->harga);
            $stmt->bindParam(':stok', $data->stok);
            $stmt->bindParam(':warna', $data->warna);
            $stmt->bindParam(':bahan', $data->bahan);
            $stmt->bindParam(':kategori', $data->kategori);
            $stmt->bindParam(':ukuran', $data->ukuran);
            $stmt->execute();
            echo json_encode(["success" => true, "msg" => "Produk berhasil ditambahkan"]);
            break;

        case 'edit':
            if (!isset($data->id)) {
                echo json_encode(["success" => false, "msg" => "ID produk tidak ditemukan"]);
                break;
            }

            $stmt = $pdo->prepare("UPDATE produk SET 
        jenis = :jenis,
        harga = :harga,
        stok = :stok,
        warna = :warna,
        bahan = :bahan,
        kategori = :kategori,
        ukuran = :ukuran
        WHERE id = :id");

            $stmt->bindParam(':jenis', $data->jenis);
            $stmt->bindParam(':harga', $data->harga);
            $stmt->bindParam(':stok', $data->stok);
            $stmt->bindParam(':warna', $data->warna);
            $stmt->bindParam(':bahan', $data->bahan);
            $stmt->bindParam(':kategori', $data->kategori);
            $stmt->bindParam(':ukuran', $data->ukuran);
            $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(['success' => true, 'msg' => 'Produk berhasil diperbarui']);
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Aksi tidak valid"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
}
