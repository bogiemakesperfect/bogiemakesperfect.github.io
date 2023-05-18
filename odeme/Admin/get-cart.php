<?php
// Veritabanı bağlantısı ve diğer gerekli işlemler

session_start();
include 'layouts/config.php';
// Sepet verilerini almak için gereken sorguyu oluşturun
$query = "SELECT viento_sepet.id, viento_sepet.adet, urunler.urunler_id, urunler.urunler_kod, urunler.urunler_isim, urunler.urunler_resim, urunler.urunler_stok, urunler.urunler_sonfiyat, urunler.urunler_kdv
          FROM viento_sepet
          INNER JOIN urunler ON viento_sepet.urunler_id = urunler.urunler_id";

// Sorguyu veritabanında çalıştırın ve sonuçları alın
$results = mysqli_query($connection, $query);


// Sonuçları JSON formatına dönüştürün
$cartData = array();
while ($row = mysqli_fetch_assoc($results)) {
    $product = array(
        'productId' => $row['urunler_id'],
        'productName' => $row['urunler_isim'],
        'productDescription' => $row['urunler_aciklama'],
        'price' => $row['urunler_sonfiyat'],
        'imageUrl' => $row['urunler_resim']
    );
    $cartData[] = $product;
}

// JSON verisini döndürün
header('Content-Type: application/json');
echo json_encode(array('cartData' => $cartData));
?>
