<?php


include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');


if (isset($_POST['updateSiparis'])) {
    // Sipariş güncelleme işlemlerini burada gerçekleştirin
    $musteriler_isim = $_POST['musteriler_isim'];
    $billing_address = $_POST['billing-address'];
    $billing_email = $_POST['billing-email'];
    $billing_phone = $_POST['billing-phone'];
    $billing_ilce = $_POST['billing-ilce'];
    $zip_code = $_POST['zip-code'];
    $siparis_kodu = $_GET['update'];


    $update = "UPDATE viento_siparisler SET siparisler_musterilerisim=?, siparisler_tamadres=?, siparisler_eposta=?, siparisler_telefon=?, siparisler_ilce=?, siparisler_zip=? WHERE siparisler_id=?";
    $stmt = $link->prepare($update);
    $stmt->bind_param('ssssssi', $musteriler_isim, $billing_address, $billing_email, $billing_phone, $billing_ilce, $zip_code, $siparis_kodu);
    $stmt->execute();
    $stmt->close();



    // Örneğin, siparişin güncellendiğini kullanıcıya bildirebilirsiniz
    echo "Sipariş başarıyla güncellendi.";

    // Yönlendirme yapabilirsiniz
    // header('Location: yeni_sayfa.php');
}





?>

<head>

    <title>Sipariş Düzenle Viento</title>

    <?php include 'layouts/head.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <?php include 'layouts/head-style.php'; ?>


</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <?php
                $maintitle = "Viento";
                $title = 'Sipariş Düzenle';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="custom-accordion">
                            <div class="card">
                                <a href="#checkout-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse">
                                    <div class="p-4">

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="bx bxs-receipt text-primary h2"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Fatura Bilgisi</h5>
                                                <p class="text-muted text-truncate mb-0">Lütfen Tüm Alanları Doldurun</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>

                                    </div>
                                </a>

                                <?php

                                $update = $_GET['update'];
                                $ret = "SELECT * FROM viento_siparisler WHERE siparisler_id = '$update'";
                                $stmt = $link->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <div id="checkout-billinginfo-collapse" class="collapse show">
                                        <div class="p-4 border-top">
                                            <form method="POST" action="">

                                                <div>


                                                    <div class="mb-0">
                                                        <label class="form-label" for="zip-code">Müşteri İsmi</label>
                                                        <input type="text" class="form-control" id="musteriler_isim" placeholder="Müşteri İsmini Girin" name="musteriler_isim" value="<?php echo $prod->siparisler_musterilerisim; ?>">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="billing-address">Tam Adres</label>
                                                        <textarea class="form-control" id="billing-address" name="billing-address" rows="3" placeholder="Enter full address"><?php echo $prod->siparisler_tamadres; ?></textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label">Şehir</label>
                                                                <select class="form-control form-select" title="Country">
                                                                    <option value="<?php echo $prod->siparisler_musterilerisim; ?>"><?php echo $prod->siparisler_sehir; ?></option>
                                                                    <option value="Adana">Adana</option>
                                                                    <option value="Adıyaman">Adıyaman</option>
                                                                    <option value="Afyonkarahisar">Afyonkarahisar</option>
                                                                    <option value="Ağrı">Ağrı</option>
                                                                    <option value="Amasya">Amasya</option>
                                                                    <option value="Ankara">Ankara</option>
                                                                    <option value="Antalya">Antalya</option>
                                                                    <option value="Artvin">Artvin</option>
                                                                    <option value="Aydın">Aydın</option>
                                                                    <option value="Balıkesir">Balıkesir</option>
                                                                    <option value="Bilecik">Bilecik</option>
                                                                    <option value="Bingöl">Bingöl</option>
                                                                    <option value="Bitlis">Bitlis</option>
                                                                    <option value="Bolu">Bolu</option>
                                                                    <option value="Burdur">Burdur</option>
                                                                    <option value="Bursa">Bursa</option>
                                                                    <option value="Çanakkale">Çanakkale</option>
                                                                    <option value="Çankırı">Çankırı</option>
                                                                    <option value="Çorum">Çorum</option>
                                                                    <option value="Denizli">Denizli</option>
                                                                    <option value="Diyarbakır">Diyarbakır</option>
                                                                    <option value="Edirne">Edirne</option>
                                                                    <option value="Elazığ">Elazığ</option>
                                                                    <option value="Erzincan">Erzincan</option>
                                                                    <option value="Erzurum">Erzurum</option>
                                                                    <option value="Eskişehir">Eskişehir</option>
                                                                    <option value="Gaziantep">Gaziantep</option>
                                                                    <option value="Giresun">Giresun</option>
                                                                    <option value="Gümüşhane">Gümüşhane</option>
                                                                    <option value="Hakkâri">Hakkâri</option>
                                                                    <option value="Hatay">Hatay</option>
                                                                    <option value="Isparta">Isparta</option>
                                                                    <option value="Mersin">Mersin</option>
                                                                    <option value="İstanbul">İstanbul</option>
                                                                    <option value="İzmir">İzmir</option>
                                                                    <option value="Kars">Kars</option>
                                                                    <option value="Kastamonu">Kastamonu</option>
                                                                    <option value="Kayseri">Kayseri</option>
                                                                    <option value="Kırklareli">Kırklareli</option>
                                                                    <option value="Kırşehir">Kırşehir</option>
                                                                    <option value="Kocaeli">Kocaeli</option>
                                                                    <option value="Konya">Konya</option>
                                                                    <option value="Kütahya">Kütahya</option>
                                                                    <option value="Malatya">Malatya</option>
                                                                    <option value="Manisa">Manisa</option>
                                                                    <option value="Kahramanmaraş">Kahramanmaraş</option>
                                                                    <option value="Mardin">Mardin</option>
                                                                    <option value="Muğla">Muğla</option>
                                                                    <option value="Muş">Muş</option>
                                                                    <option value="Nevşehir">Nevşehir</option>
                                                                    <option value="Niğde">Niğde</option>
                                                                    <option value="Ordu">Ordu</option>
                                                                    <option value="Rize">Rize</option>
                                                                    <option value="Sakarya">Sakarya</option>
                                                                    <option value="Samsun">Samsun</option>
                                                                    <option value="Siirt">Siirt</option>
                                                                    <option value="Sinop">Sinop</option>
                                                                    <option value="Sivas">Sivas</option>
                                                                    <option value="Tekirdağ">Tekirdağ</option>
                                                                    <option value="Tokat">Tokat</option>
                                                                    <option value="Trabzon">Trabzon</option>
                                                                    <option value="Tunceli">Tunceli</option>
                                                                    <option value="Şanlıurfa">Şanlıurfa</option>
                                                                    <option value="Uşak">Uşak</option>
                                                                    <option value="Van">Van</option>
                                                                    <option value="Yozgat">Yozgat</option>
                                                                    <option value="Zonguldak">Zonguldak</option>
                                                                    <option value="Aksaray">Aksaray</option>
                                                                    <option value="Bayburt">Bayburt</option>
                                                                    <option value="Karaman">Karaman</option>
                                                                    <option value="Kırıkkale">Kırıkkale</option>
                                                                    <option value="Batman">Batman</option>
                                                                    <option value="Şırnak">Şırnak</option>
                                                                    <option value="Bartın">Bartın</option>
                                                                    <option value="Ardahan">Ardahan</option>
                                                                    <option value="Iğdır">Iğdır</option>
                                                                    <option value="Yalova">Yalova</option>
                                                                    <option value="Karabük">Karabük</option>
                                                                    <option value="Kilis">Kilis</option>
                                                                    <option value="Osmaniye">Osmaniye</option>
                                                                    <option value="Düzce">Düzce</option>





                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="billing-ilce">İlçe</label>
                                                                <input type="text" class="form-control" id="billing-ilce" name="billing-ilce" placeholder="İlçe Girin" value="<?php echo $prod->siparisler_ilce; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="zip-code">Posta kodu</label>
                                                                <input type="text" class="form-control" id="zip-code" name="zip-code" placeholder="Posta Kodunu Girin" value="<?php echo $prod->siparisler_zip; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-4">


                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="billing-email">Eposta Adresi</label>
                                                                <input type="text" class="form-control" id="billing-email" name="billing-email" placeholder="Eposta Adresini Girin" value="<?php echo $prod->siparisler_eposta; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="billing-phone">Telefon Numarası</label>
                                                                <input type="text" class="form-control" id="billing-phone" name="billing-phone" placeholder="Telefon Numarasını Girin" value="<?php echo $prod->siparisler_telefon; ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                <?php } ?>

                            </div>


                        </div>


                    </div>
                    <div class="col-xl-12">
                        <div class="card checkout-order-summary">
                            <div class="card-body">
                                <div class="p-3 bg-light mb-4">
                                    <h5 class="font-size-16 mb-0">Ürünler <span class="float-end ms-2"></span></h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 table-nowrap" id="cart-summary">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0" scope="col">Ürün</th>
                                                <th class="border-top-0" scope="col">Ürün Adı</th>
                                                <th class="border-top-0">Adet</th>
                                                <th class="border-top-0" scope="col">Fiyat</th>
                                                <!--      <th class="border-top-0">Adet</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Siparişe ait ürünleri ve ürün ayrıntılarını almak için bir JOIN sorgusu yapın
                                            $siparis_kodu = $_GET['update'];
                                            $query = "SELECT su.urunler_resim, su.urunler_id, su.urunler_adet, su.urunler_sonfiyat, vu.urunler_isim 
                                                                FROM viento_siparis_urunleri su 
                                                                JOIN viento_urunler vu ON su.urunler_id = vu.urunler_id
                                                                WHERE su.siparis_id = $siparis_kodu";
                                            $stmt = $link->prepare($query);
                                            $stmt->execute();
                                            $res = $stmt->get_result();

                                            while ($row = $res->fetch_object()) {
                                                $urunler_resim = $row->urunler_resim;
                                                $urunler_id = $row->urunler_id;
                                                $urun_adi = $row->urunler_isim;
                                                $adet = $row->urunler_adet;
                                                $fiyat = $row->urunler_sonfiyat;

                                                echo "<tr>";

                                                if ($urunler_resim) {
                                                    echo "<td><img src='/odeme/Admin/assets/img/products/$urunler_resim' height='60' width='60' class='img-thumbnail'></td>";
                                                } else {
                                                    echo "<td><img src='/odeme/Admin/assets/img/products/viento_default.jpeg' height='60' width='60' class='img-thumbnail'></td>";
                                                }

                                                echo "<td class='border-top-0'>$urun_adi</td>";
                                                echo "<td class='border-top-0'>$adet</td>";
                                                echo "<td class='border-top-0'>$fiyat</td>";

                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>



                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col">
                                <div class="text-end mt-2 mt-sm-0">
                                    <?php
                                    $totalPrice = 0;
                                    $query = "SELECT * FROM viento_siparis_urunleri WHERE siparis_id = '$siparis_kodu'";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                        $subtotal = $row->urunler_sonfiyat * $row->urunler_adet;
                                        $totalPrice += $subtotal;
                                    }
                                    ?>
                                    <h5>Toplam Fiyat: <?php echo $totalPrice; ?> TL</h5>

                                    <!-- <input type="hidden" name="odemekodu" value="<?php echo $cus_id; ?>" class="form-control"> -->
                                    <!-- Seçilen müşterinin ID'si -->

                                    <button type="submit" name="updateSiparis" class="btn btn-success">
                                        <i class="mdi mdi-cart-outline me-1"></i> Siparişi Düzenle
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end row-->

                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/js/app.js"></script>

</body>

</html>