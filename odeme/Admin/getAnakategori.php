<?php
// Veritabanı bağlantısı yapın
include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';

// Ana kategori id'sini POST yöntemiyle alın
if (isset($_POST['anaKategoriId'])) {
    $anaKategoriId = $_POST['anaKategoriId'];
    
    $sorgu = "SELECT anakategori_isim FROM viento_anakategori WHERE anakategori_id = $anaKategoriId";
    $sonuc = $link->query($sorgu);
    
    if ($sonuc->num_rows > 0) {
        $row = $sonuc->fetch_assoc();
        echo $row['anakategori_isim'];
    }
}