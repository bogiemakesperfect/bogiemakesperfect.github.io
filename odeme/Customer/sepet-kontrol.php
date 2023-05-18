<?php
// Veritabanı bağlantısı ve diğer gereken işlemler
session_start();
include 'layouts/config.php';
// Sepet kontrolü için gerekli işlemleri gerçekleştirin

// AJAX isteğinden gelen ürün ID'sini alın
$urun_id = $_POST['urun_id'];

// Sepet tablosunda ilgili ürünü arayın
$query = "SELECT * FROM viento_sepet WHERE urunler_id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("s", $urun_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ürün sepette mevcut
    

    echo 'true';
} else {
    // Ürün sepette mevcut değil
    echo 'false';
}

// Veritabanı bağlantısını kapatın ve diğer gerekli işlemler
?>
