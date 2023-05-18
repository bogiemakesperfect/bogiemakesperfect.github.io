<?php
session_start();
include 'layouts/config.php';

// Bağlantıyı kontrol edin

$customerId = $_POST['musteri_id'];
// Güvenlik önlemi olarak gelen müşteri ID'sini filtreleyin
$customerId = mysqli_real_escape_string($link, $customerId);

// Müşteri bilgilerini veritabanından çekin
$sql = "SELECT * FROM viento_musteriler WHERE musteriler_id = '$customerId'";
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // İlk sıradaki kaydı alın
    $customer = mysqli_fetch_assoc($result);

    // Müşteri bilgilerini JSON formatına dönüştürün
    $customerDetails = array(
        'address' => $customer['musteriler_teslimat'],
        'telefon' => $customer['musteriler_telefon'],
        'isim' => $customer['musteriler_isim'],
        'kdv' => $customer['musteriler_kdv'],
        'vergino' => $customer['musteriler_vergino'],
        'vergidairesi' => $customer['musteriler_vergidairesi'],
        'email' => $customer['musteriler_eposta'],
        'sehir' => $customer['musteriler_sehir'],
        'ilce' => $customer['musteriler_ilce'],
        'zip' => $customer['musteriler_zip'],
        // Diğer müşteri bilgilerini buraya ekleyin
    );

    // JSON yanıtını döndürün
    echo json_encode($customerDetails);
} else {
    // Müşteri bulunamadıysa hata mesajı döndürün
    echo "Müşteri bulunamadı";
}

// Veritabanı bağlantısını kapatın
mysqli_close($link);
?>