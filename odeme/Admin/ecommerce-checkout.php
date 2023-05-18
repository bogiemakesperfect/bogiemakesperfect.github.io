<?php


include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM viento_urunler WHERE urunler_isim LIKE '%$search%' OR urunler_kod LIKE '%$search%'";
} else {
    $query = "SELECT * FROM viento_urunler ORDER BY urunler_olusturmatarihi DESC";
}
$stmt = $link->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

if (isset($_POST['onayla'])) {
    // Sipariş bilgilerini al
    $query = "SELECT * FROM viento_sepet INNER JOIN viento_urunler ON viento_sepet.urunler_id = viento_urunler.urunler_id WHERE viento_sepet.admin_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $res = $stmt->get_result();

    // Check if there are items in the cart
    if ($res->num_rows == 0) {
        echo "<script>alert('Sepetinizde ürün bulunmamaktadır.');</script>";
    } else {
        if (empty($_POST['musteriler_isim']) || empty($_POST['billing-address']) || empty($_POST['billing-email']) || empty($_POST['billing-phone']) || empty($_POST['siparisler_sehir']) || empty($_POST['billing-ilce']) || empty($_POST['zip-code'])) {
            echo "<script>alert('Müşteri bilgilerini doldurun.');</script>";
        } else {
            $odemekodu = uniqid();
            $musterilerid = $_SESSION['id'];
            $siparisdurum = "Onay Bekliyor";
            $musteriler_isim = $_POST['musteriler_isim'];
            $tamadres = $_POST['billing-address'];
            $sehir = $_POST['siparisler_sehir'];
            $ilce = $_POST['billing-ilce'];
            $zip = $_POST['zip-code'];
            $eposta = $_POST['billing-email'];
            $telefon = $_POST['billing-phone'];




            // Siparişleri sepet tablosundan al
            $query = "SELECT * FROM viento_sepet INNER JOIN viento_urunler ON viento_sepet.urunler_id = viento_urunler.urunler_id WHERE viento_sepet.admin_id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $res = $stmt->get_result();

            // Siparişi viento_siparisler tablosuna ekle
            $insertQuery = "INSERT INTO viento_siparisler (siparisler_odemekodu, siparisler_musterilerid, siparisler_musterilerisim,siparisler_tamadres,siparisler_sehir,siparisler_ilce,siparisler_zip, siparisler_eposta,siparisler_telefon, siparisler_siparisdurum, siparisler_olusturmatarihi) VALUES (?, ?, ?, ? , ? , ? , ? , ? ,?,? , NOW())";
            $insertStmt = $link->prepare($insertQuery);
            $insertStmt->bind_param("ssssssisss", $odemekodu, $musterilerid, $musteriler_isim, $tamadres, $sehir, $ilce, $zip, $eposta, $telefon, $siparisdurum);
            $insertStmt->execute();

            // Sipariş ID'sini al
            $siparisID = $insertStmt->insert_id;


            // Siparişteki her ürünü viento_siparis_urunleri tablosuna ekle
            while ($prod = $res->fetch_object()) {
                $urunlerid = $prod->urunler_kod;
                $urunlerresim = $prod->urunler_resim;
                $urunlersonfiyat = $prod->urunler_sonfiyat;
                $urunleradet = $prod->adet;


                $insertUrunQuery = "INSERT INTO viento_siparis_urunleri (siparis_id, urunler_id,urunler_resim, urunler_sonfiyat, urunler_adet) VALUES (?, ?, ?, ? , ?)";
                $insertUrunStmt = $link->prepare($insertUrunQuery);
                $insertUrunStmt->bind_param("isssi", $siparisID, $urunlerid, $urunlerresim, $urunlersonfiyat, $urunleradet);
                $insertUrunStmt->execute();
            }

            // Sepeti temizle
            $deleteQuery = "DELETE FROM viento_sepet WHERE admin_id = ?";
            $deleteStmt = $link->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $_SESSION['id']);
            $deleteStmt->execute();

            // Yönlendirme yap
            header("Location: ecommerce-orders.php");
            exit();
        }
    }
}




?>

<head>

    <title><?php echo $language["Checkout"]; ?> Viento</title>

    <?php include 'layouts/head.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <?php include 'layouts/head-style.php'; ?>
    <script>
        $(document).ready(function() {


            $('.btn-add-to-cart').click(function(e) {
                e.preventDefault();

                var urun_id = $(this).data('urun-id');
                var adet = $(this).closest('td').find('.form-control').val();
                var button = $(this);

                // Kontrol için AJAX isteği gönderme
                $.ajax({
                    url: '/odeme/Admin/sepet-kontrol.php', // Ürünlerin bulunduğu sepeti kontrol eden PHP dosyasının yolunu buraya yazın
                    method: 'POST',
                    data: {
                        urun_id: urun_id
                    },
                    success: function(response) {
                        // Sepet kontrolü başarılı olduğunda yapılacak işlemler
                        if (response === 'true') {
                            // Ürün zaten sepette var, eklemeyi iptal et
                            console.log('Ürün zaten sepette mevcut.');
                        } else {
                            // Ürünü sepete ekleme isteği gönderme
                            $.ajax({
                                url: '/odeme/Admin/sepete-ekle.php', // Sepete ürün ekleme işlemini gerçekleştiren PHP dosyasının yolunu buraya yazın
                                method: 'POST',
                                data: {
                                    urun_id: urun_id,

                                    adet: adet
                                },
                                success: function(response) {
                                    console.log('Ürün sepete eklendi ajax success.');
                                    button.text("Sepete Eklendi");
                                    button.prop("disabled", true);

                                    updateCart();
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on("click", "button[data-action='decrease']", function() {
                var button = $(this);
                var urunId = button.data("urun-id");
                var input = button.closest(".input-group").find("input");
                var adet = parseInt(input.val());

                if (adet > 1) {
                    adet--;
                    input.val(adet);


                    // Toplam fiyatı güncelle

                    // Adeti güncelleme isteği gönderme

                    updateAdet(urunId, adet);
                    updateCart();

                }
            });


            $(document).on("click", "button[data-action='increase']", function() {
                var button = $(this);
                var urunId = button.data("urun-id");
                var input = button.closest(".input-group").find("input");
                var adet = parseInt(input.val());

                if (adet < 100) {
                    adet++;
                    input.val(adet);

                    updateAdet(urunId, adet);
                    updateCart();

                }
            });
            $(document).ready(function() {
                $('#choices-single-category').on('change', function() {
                    var customerId = $(this).val();
                    getCustomerDetails(customerId);
                });
            });

            function getCustomerDetails(customerId) {
                $.ajax({
                    url: '/odeme/Admin/get-customer-details.php',
                    type: 'POST',
                    data: {
                        musteri_id: customerId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Müşteri bilgilerini form alanlarına doldurun

                        document.getElementById("siparisler_sehir").value = response.sehir;
                        document.getElementById("billing-ilce").value = response.ilce;
                        document.getElementById("zip-code").value = response.zip;
                        document.getElementById("musteriler_isim").value = response.isim;
                        document.getElementById("billing-address").value = response.address;
                        document.getElementById("billing-email").value = response.email;
                        document.getElementById("billing-phone").value = response.telefon;
                        document.getElementById("musterikdv").value = response.kdv;






                        /* disabled all */
                        $('#billing-address').prop('disabled', true);
                        $('#musteriler_isim').prop('disabled', true);
                        $('#billing-email').prop('disabled', true);
                        $('#billing-phone').prop('disabled', true);
                        $('#musterikdv').prop('disabled', true);
                        $('#siparisler_sehir').prop('disabled', true);
                        $('#billing-ilce').prop('disabled', true);
                        /* disabled all */

                    },
                    error: function() {
                        // Hata durumunda işlem yapılabilir
                    }
                });
            }


            function onCustomerSelectionChange() {
                var customerId = $('#choices-single-category').val();
                if (customerId !== '') {
                    getCustomerDetails(customerId);
                }
            }

            // Müşteri seçimi değiştiğinde onCustomerSelectionChange() fonksiyonunu çağırın
            $('#choices-single-category').change(onCustomerSelectionChange);






            $(document).on("click", ".btn-remove-from-cart", function() {
                var button = $(this);
                var urunId = button.data("urun-id");

                // Ürünü sepetten kaldırma isteği gönderme
                removeFromCart(urunId);
                $(".btn-add-to-cart[data-urun-id='" + urunId + "']").prop("disabled", false);
                /* change button text */
                $(".btn-add-to-cart[data-urun-id='" + urunId + "']").text("Sepete Ekle");
            });


            function updateAdet(urunId, adet) {
                $.ajax({
                    url: "update-cart.php",
                    method: "POST",
                    data: {
                        urun_id: urunId,
                        adet: adet
                    },
                    success: function(response) {
                        // Başarılı bir şekilde güncellendiğinde yapılacak işlemler
                        console.log("Ürün adedi güncellendi.");

                        // Sepeti güncelle
                        updateCart();
                    },
                    error: function() {
                        // Güncelleme başarısız olduğunda yapılacak işlemler
                        console.log("Ürün adedi güncellenirken bir hata oluştu.");
                    }
                });
            }

            function updateTotalPrice() {
                var totalPrice = 0;
                $('#cart-summary tbody tr').each(function() {
                    var price = parseFloat($(this).find('td:nth-child(4)').text());
                    var quantity = parseInt($(this).find('input.form-control').val());
                    totalPrice += price * quantity;
                });
                $('.text-end h5').text('Toplam Fiyat: ' + totalPrice + ' TL');
            }

            function removeFromCart(urunId) {
                $.ajax({
                    url: "remove-from-cart.php",
                    method: "POST",
                    data: {
                        urun_id: urunId
                    },
                    success: function(response) {
                        // Başarılı bir şekilde kaldırıldığında yapılacak işlemler
                        console.log("Ürün sepetten kaldırıldı.");

                        // Sepeti güncelle
                        updateCart();
                    },
                    error: function() {
                        // Kaldırma işlemi başarısız olduğunda yapılacak işlemler
                        console.log("Ürün sepetten kaldırılırken bir hata oluştu.");
                    }
                });
            }

            function updateCart() {
                $.ajax({
                    url: '/odeme/Admin/sepet-guncelle.php',
                    method: 'GET',
                    success: function(response) {
                        // Sepet tablosunu güncelle
                        $('#cart-summary tbody').html(response);

                        updateTotalPrice();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
        document.getElementById("choices-single-category").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var customerName = selectedOption.text;
            var customerAddress = selectedOption.getAttribute("data-address");



        });
    </script>

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
                $title = 'Sipariş Oluştur';
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

                                <div id="checkout-billinginfo-collapse" class="collapse">
                                    <div class="p-4 border-top">
                                        <form method="POST" action="">
                                            <div>
                                                <div class="row">

                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label">Müşteri Seç</label>
                                                        <select class="form-control" data-trigger name="choices-single-category" id="choices-single-category">
                                                            <option value="new" selected>Yeni Müşteri</option>
                                                            <?php
                                                            $query = "SELECT * FROM viento_musteriler";
                                                            $stmt = $link->prepare($query);
                                                            $stmt->execute();
                                                            $res = $stmt->get_result();
                                                            while ($customer = $res->fetch_object()) {
                                                            ?>
                                                                <option value="<?php echo $customer->musteriler_id; ?>"><?php echo $customer->musteriler_isim; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label" for="zip-code">Müşteri İsmi</label>
                                                    <!-- make hide input  -->

                                                    <input type="text" class="form-control" id="musteriler_isim" placeholder="Müşteri İsmini Girin" name="musteriler_isim">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="billing-address">Tam Adres</label>
                                                    <textarea class="form-control" id="billing-address" name="billing-address" rows="3" placeholder="Tam adresini Gir"></textarea>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-4 mb-lg-0">
                                                            <label class="form-label">Şehir</label>
                                                            <input type="text" class="form-control" id="siparisler_sehir" name="siparisler_sehir" placeholder="Şehir Girin">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="mb-4 mb-lg-0">
                                                            <label class="form-label" for="billing-ilce">İlçe</label>
                                                            <input type="text" class="form-control" id="billing-ilce" name="billing-ilce" placeholder="İlçe Girin">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="mb-0">
                                                            <label class="form-label" for="zip-code">Posta kodu</label>
                                                            <input type="text" class="form-control" id="zip-code" name="zip-code" placeholder="Posta Kodunu Girin">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row my-4">


                                                    <div class="col-lg-4">
                                                        <div class="mb-4 mb-lg-0">
                                                            <label class="form-label" for="billing-email">Eposta Adresi</label>
                                                            <input type="text" class="form-control" id="billing-email" name="billing-email" placeholder="Eposta Adresini Girin">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="mb-0">
                                                            <label class="form-label" for="billing-phone">Telefon Numarası</label>
                                                            <input type="text" class="form-control" id="billing-phone" name="billing-phone" placeholder="Telefon Numarasını Girin">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <a href="#checkout-paymentinfo-collapse" class="collapsed text-dark" data-bs-toggle="collapse">
                                    <div class="p-4">

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="bx bxs-wallet-alt text-primary h2"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Ürün Ekle</h5>
                                                <p class="text-muted text-truncate mb-0">Sepete Eklemek İçin Ürün Seçin</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>

                                    </div>
                                </a>

                                <div id="checkout-paymentinfo-collapse" class="collapse show">
                                    <div class="p-4 border-top">

                                        <div>


                                            <div class="row">

                                                <div class="col-xl-12">

                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <div class="col-sm-4">
                                                                    <div class="search-box me-2 mb-2 d-inline-block">
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" placeholder="Search...">
                                                                            <i class="bx bx-search-alt search-icon"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="card-body pt-xl-1">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Ürün Resmi</th>

                                                                            <th>Stok Kodu</th>
                                                                            <th>Ürün İsmi</th>


                                                                            <th>Kdv</th>

                                                                            <th>Fiyat</th>
                                                                            <th>Adet</th>

                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <?php
                                                                        $query = isset($_POST['search']) ? "SELECT * FROM viento_urunler WHERE urunler_isim LIKE '%$search%' " : "SELECT * FROM viento_urunler ORDER BY urunler_olusturmatarihi DESC";
                                                                        $stmt = $link->prepare($query);
                                                                        $stmt->execute();
                                                                        $res = $stmt->get_result();
                                                                        while ($prod = $res->fetch_object()) {
                                                                        ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($prod->urunler_resim) {
                                                                                        echo "<img src='/odeme/Admin/assets/img/products/$prod->urunler_resim' height='100' width='100' class='img-thumbnail'>";
                                                                                    } else {
                                                                                        echo "<img src='/odeme/Admin/assets/img/products/viento_default.jpeg' height='60' width='60 class='img-thumbnail'>";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $prod->urunler_kod; ?></td>
                                                                                <td><?php echo $prod->urunler_isim; ?></td>

                                                                                <td><?php echo $prod->urunler_kdv; ?></td>

                                                                                <td><?php echo $prod->urunler_sonfiyat; ?> TL</td>
                                                                                <td>

                                                                                    <input type="hidden" name="urun_id" value="<?php echo $prod->urunler_id; ?>">
                                                                                    <input type="number" name="adet" value="1" min="1" max="100" class="form-control">
                                                                                    <button type="button" class="btn btn-success btn-sm mt-2 btn-add-to-cart" data-urun-id="<?php echo $prod->urunler_id; ?>"><i class="mdi mdi-cart-plus"></i> Sepete Ekle</button>
                                                                                    <!-- <button type="submit" name="add_to_cart" class="btn btn-success btn-sm mt-2"><i class="mdi mdi-cart-plus"></i> Sepete Ekle</button> -->

                                                                                </td>

                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>


                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="col-xl-12">
                        <div class="card checkout-order-summary">
                            <div class="card-body">
                                <div class="p-3 bg-light mb-4">
                                    <h5 class="font-size-16 mb-0">Sepet <span class="float-end ms-2"></span></h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 table-nowrap" id="cart-summary">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0" style="width: 110px;" scope="col">Ürün</th>
                                                <th class="border-top-0" scope="col">Ürün Adı</th>
                                                <th class="border-top-0">Adet</th>
                                                <th class="border-top-0" scope="col">Fiyat</th>
                                                <th class="border-top-0">Adet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM viento_sepet INNER JOIN viento_urunler ON viento_sepet.urunler_id = viento_urunler.urunler_id WHERE viento_sepet.admin_id = '" . $_SESSION['id'] . "'";
                                            $stmt = $link->prepare($query);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($prod = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        if ($prod->urunler_resim) {
                                                            echo "<img src='/odeme/Admin/assets/img/products/$prod->urunler_resim' height='60' width='60' class='img-thumbnail'>";
                                                        } else {
                                                            echo "<img src='/odeme/Admin/assets/img/products/viento_default.jpeg' height='60' width='60' class='img-thumbnail'>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $prod->urunler_isim; ?></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <button class="btn btn-outline-secondary" type="button" data-urun-id="<?php echo $prod->urunler_id; ?>" data-action="decrease">-</button>
                                                            <input type="number" class="form-control" value="<?php echo $prod->adet; ?>" min="1" max="100" readonly>
                                                            <button class="btn btn-outline-secondary" type="button" data-urun-id="<?php echo $prod->urunler_id; ?>" data-action="increase">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="product-price" data-price="<?php echo $prod->urunler_sonfiyat; ?>"><?php echo $prod->urunler_sonfiyat; ?> TL</td>

                                                    <td>
                                                        <button class="btn btn-danger btn-remove-from-cart" type="button" data-urun-id="<?php echo $prod->urunler_id; ?>">Sepetten Kaldır</button>
                                                    </td>

                                                </tr>
                                            <?php } ?>

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
                                    $query = "SELECT * FROM viento_sepet INNER JOIN viento_urunler ON viento_sepet.urunler_id = viento_urunler.urunler_id WHERE viento_sepet.admin_id = '" . $_SESSION['id'] . "'";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($prod = $res->fetch_object()) {
                                        $totalPrice += $prod->urunler_sonfiyat * $prod->adet;
                                        $urunlerresim = $prod->urunler_resim;
                                    }

                                    ?>
                                    <h5>Toplam Fiyat: <?php echo $totalPrice; ?> TL</h5>

                                    <input type="hidden" name="odemekodu" value="<?php echo $cus_id; ?>" class="form-control">

                                    <!-- secilen musterinin id si -->



                                    <button type="submit" name="onayla" class="btn btn-success">
                                        <i class="mdi mdi-cart-outline me-1"></i> Siparişi Onayla
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