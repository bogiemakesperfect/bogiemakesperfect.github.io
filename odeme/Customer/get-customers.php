<?php
include 'layouts/config.php';

// Müşterileri veritabanından çekin
$query = "SELECT * FROM viento_musteriler";
$result = $link->query($query);

if ($result->num_rows > 0) {
    while ($customer = $result->fetch_assoc()) {
        // Her bir müşteriyi liste olarak oluşturun
        echo '<div>'.$customer['musteriler_isim'].'</div>';
    }
} else {
    echo 'Müşteri bulunamadı';
}

// Veritabanı bağlantısını kapatın
$link->close();
?>