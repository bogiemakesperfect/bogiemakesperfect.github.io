<?php
session_start();
include 'layouts/config.php';

if(isset($_SESSION['customer_id'])){
    $customer_id = $_SESSION['customer_id'];
    

    // Sepet içeriğini sorgula
    $query = "SELECT * FROM viento_sepet INNER JOIN viento_urunler ON viento_sepet.urunler_id = viento_urunler.urunler_id WHERE viento_sepet.musteriler_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Sepet içeriği varsa
        while ($prod = $res->fetch_object()) {
            // Her ürün için tablo satırını oluştur
            echo '<tr>
                    <td>
                        <img src="/odeme/Admin/assets/img/products/' . ($prod->urunler_resim ? $prod->urunler_resim : 'viento_default.jpeg') . '" height="60" width="60" class="img-thumbnail">
                    </td>
                    <td>' . $prod->urunler_isim . '</td>
                    <td>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button" data-urun-id="' . $prod->urunler_id . '" data-action="decrease">-</button>
                            <input type="number" class="form-control" value="' . $prod->adet . '" min="1" max="100" readonly> 
                            <button class="btn btn-outline-secondary" type="button" data-urun-id="' . $prod->urunler_id . '" data-action="increase">+</button>
                        </div>
                    </td>
                    <td>' . $prod->urunler_sonfiyat . ' TL</td>
                    <td>
                        <button class="btn btn-danger btn-remove-from-cart" type="button" data-urun-id="' . $prod->urunler_id . '">Sepetten Kaldır</button>
                    </td>
                </tr>';
        }
    } else {
        // Sepet boşsa
        echo '<tr>
                <td colspan="5">Sepetiniz boş.</td>
            </tr>';
    }

   
    


} else {
    // Oturum yoksa veya kullanıcı giriş yapmamışsa
    echo '<tr>
            <td colspan="5">Oturum açmadınız.</td>
        </tr>';
}
