<?php

session_start();
include 'layouts/config.php';
if (isset($_POST['urun_id'])) {
    if (empty($_POST['urun_id'])) {
        // Gerekli alanları doldurmadığınızda yapılacak işlemler
        echo "Lütfen gerekli alanları doldurun.";
        exit;
    }

    // Veritabanına bağlan

    // Veritabanına bağlanmak için kullanacağınız bilgileri girin

    // Burada viento_sepet tablosundan ilgili ürünü kaldırın
    $urun_id = $_POST['urun_id'];

    // Örnek bir silme sorgusu
    $deleteQuery = "DELETE FROM viento_sepet WHERE urunler_id = ?";
    $stmt = $link->prepare($deleteQuery);
    $stmt->bind_param("s", $urun_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Başarılı bir şekilde silindiğinde yapılacak işlemler
        echo "Ürün sepetten kaldırıldı.";
        /* refresh the page */
          
    } else {
        // Silme işlemi başarısız olduğunda yapılacak işlemler
        echo "Ürün sepetten kaldırılırken bir hata oluştu.";
    }

    // Veritabanı bağlantısını kapatın
    $stmt->close();
    $link->close();
}
?>
