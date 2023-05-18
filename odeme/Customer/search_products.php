<?php
// Assuming you have a database connection established
session_start();
include 'layouts/config.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';

// SQL sorgusunu hazırlayın
$query = "SELECT * FROM viento_urunler WHERE urunler_isim LIKE '%$search%' ORDER BY urunler_olusturmatarihi DESC";
$stmt = $link->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

// Arama sonuçlarını döngüyle gösterin
while ($prod = $res->fetch_object()) {
    echo "<tr>";
    echo "<td>";
    if ($prod->urunler_resim) {
        echo "<img src='/odeme/Admin/assets/img/products/$prod->urunler_resim' height='100' width='100' class='img-thumbnail'>";
    } else {
        echo "<img src='/odeme/Admin/assets/img/products/viento_default.jpeg' height='60' width='60' class='img-thumbnail'>";
    }
    echo "</td>";
    echo "<td>{$prod->urunler_kod}</td>";
    echo "<td>{$prod->urunler_isim}</td>";
    echo "<td>{$prod->urunler_kdv}</td>";
    echo "<td>{$prod->urunler_sonfiyat} TL</td>";
    echo "<td>";
    echo "<input type='hidden' name='urun_id' value='{$prod->urunler_id}'>";
    echo "<input type='number' name='adet' value='1' min='1' max='100' class='form-control'>";
    echo "<button type='button' class='btn btn-success btn-sm mt-2 btn-add-to-cart' data-urun-id='{$prod->urunler_id}'><i class='mdi mdi-cart-plus'></i> Sepete Ekle</button>";
    echo "</td>";
    echo "</tr>";
}

// Veritabanı bağlantısını kapatın
$stmt->close();
$link->close();
