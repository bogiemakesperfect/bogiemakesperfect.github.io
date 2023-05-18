<?php
session_start();
include 'layouts/config.php';


if (isset($_POST['urun_id']) && isset($_POST['adet'])) {
    if (empty($_POST['urun_id']) || empty($_POST['adet'])) {
        // Gerekli alanları doldurmadığınızda yapılacak işlemler
        echo "Lütfen gerekli alanları doldurun.";/*  */
    }

    $id = $_SESSION['id'];
    $urun_id = $_POST['urun_id'];
    $adet = $_POST['adet'];
    


    // Veritabanına bağlan

    // Veritabanına bağlanmak için kullanacağınız bilgileri girin
    $postQuery = "INSERT INTO viento_sepet (urunler_id, admin_id, adet) VALUES ('$urun_id', '$id', '$adet')";
    $stmt = $link->prepare($postQuery);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Başarılı bir şekilde eklendiğinde yapılacak işlemler
        echo "Ürün sepete eklendi.";
    
    } else {
        // Ekleme başarısız olduğunda yapılacak işlemler
        echo "Ürün sepete eklenirken bir hata oluştu.";
    }

    // Veritabanı bağlantısını kapatın
    $stmt->close();
    $link->close();
}

/* if (isset($_POST['add_to_cart'])) {
    // Form verilerini al
    $id = $_SESSION['id'];
    $urun_id = $_POST['urun_id'];
    $adet = $_POST['adet'];

    // Veritabanına bağlan

    // Veritabanına bağlanmak için kullanacağınız bilgileri girin
    $postQuery = "INSERT INTO viento_sepet (urunler_id, admin_id, adet) VALUES ('$urun_id', '$id', '$adet')";
    $stmt = $link->prepare($postQuery);
    $stmt->execute();
    $res = $stmt->get_result();
} */