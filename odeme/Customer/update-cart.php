<?php

session_start();
include 'layouts/config.php';
if (isset($_POST['urun_id']) && isset($_POST['adet'])) {
    if (empty($_POST['urun_id']) || empty($_POST['adet'])) {
        // Gerekli alanları doldurmadığınızda yapılacak işlemler
        echo "Lütfen gerekli alanları doldurun.";
    } else {
        $id = $_SESSION['customer_id'];
        $urun_id = $_POST['urun_id'];
        $adet = $_POST['adet'];

        // Veritabanına bağlan

        // Veritabanına bağlanmak için kullanacağınız bilgileri girin
        $updateQuery = "UPDATE viento_sepet SET adet = ? WHERE urunler_id = ? AND musteriler_id = ?";
        $stmt = $link->prepare($updateQuery);
        $stmt->bind_param("isi", $adet, $urun_id, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Başarılı bir şekilde güncellendiğinde yapılacak işlemler
            echo "Ürün adeti güncellendi.";
        } else {
            // Güncelleme başarısız olduğunda yapılacak işlemler
            echo "Ürün adeti güncellenirken bir hata oluştu.";
        }

        // Veritabanı bağlantısını kapatın
        $stmt->close();
        $link->close();
    }
}
?>
