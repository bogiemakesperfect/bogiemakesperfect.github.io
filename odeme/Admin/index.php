<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>
<?php include 'layouts/config.php'; ?>
<?php
if ($_SESSION['role'] !== 'admin') {
    // Kullanıcıyı başka bir sayfaya yönlendir veya hata mesajı göster
    header('Location: /odeme/admin/auth-login.php');
    exit();
} 
?>


<head>

    <title><?php echo $language["Dashboard"]; ?> Viento</title>

    <?php include 'layouts/head.php'; ?>

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
                $maintitle = "Symox";
                $title = 'Hoşgeldin !';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <div class="text-center py-4">
                                    <ul class="bg-bubbles ps-0">
                                        <li><i class="bx bx-grid-alt font-size-24"></i></li>
                                        <li><i class="bx bx-tachometer font-size-24"></i></li>
                                        <li><i class="bx bx-store font-size-24"></i></li>
                                        <li><i class="bx bx-cube font-size-24"></i></li>
                                        <li><i class="bx bx-cylinder font-size-24"></i></li>
                                        <li><i class="bx bx-command font-size-24"></i></li>
                                        <li><i class="bx bx-hourglass font-size-24"></i></li>
                                        <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                                        <li><i class="bx bx-coffee font-size-24"></i></li>
                                        <li><i class="bx bx-polygon font-size-24"></i></li>
                                    </ul>
                                    <div class="main-wid position-relative">
                                        <h3 class="text-white">Viento Gösterge Paneli</h3>

                                        <h3 class="text-white mb-0"> Hoşgeldin</h3>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--   <div class="col-xl-8">
                        <div class="row">
                          

                            <div class="col-lg-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="avatar">
                                            <span class="avatar-title bg-soft-success rounded">
                                                <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                            </span>
                                        </div>
                                        <p class="text-muted mt-4 mb-0">Bugün Ziyaretçileri</p>
                                        <h4 class="mt-1 mb-0">0</h4>
                                        
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div> -->
                </div>

                <!-- <div class="row">
                   
                   <div class="col-xl-12">
                       <div class="card">
                           <div class="card-header">
                               <div class="d-flex flex-wrap align-items-center">
                                   <h5 class="card-title mb-0">Ürünler</h5>
                                   <div class="ms-auto">
                                    <a href="ecommerce-add-product.php"> <button  type="button" class="btn btn-success waves-effect waves-light" >Ürün Ekle</button></a>
                                  
                                   </div>
                               </div>
                           </div>
                           <div class="card-body pt-xl-1">
                               <div class="table-responsive">
                                   <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                                       <thead>
                                           <tr>
                                               <th>No</th>
                                               <th>Product's Name</th>
                                               <th>Variant</th>
                                               <th>Type</th>
                                               <th>Stock</th>
                                               <th>Price</th>
                                               <th>Sales</th>
                                               <th>Status</th>
                                               <th>Edit</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                         

                                       </tbody>
                                   </table>
                               </div>
                           </div>
                       </div>
                   </div>
               </div> -->


                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="avatar">
                                        <span class="avatar-title bg-soft-primary rounded">
                                            <i class="mdi mdi-shopping-outline text-primary font-size-24"></i>
                                        </span>
                                    </div>
                                    <p class="text-muted mt-4 mb-0">Siparişler</p>
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM viento_siparisler";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $totalVeriSayisi = $row->total;

                                    // Günlük sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_siparisler WHERE siparisler_olusturmatarihi >= CURDATE()";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $gunlukOrtalama = $row->total / 1; // Günlük ortalama

                                    // Haftalık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_siparisler WHERE siparisler_olusturmatarihi >= CURDATE() - INTERVAL 7 DAY";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $haftalikOrtalama = $row->total / 7; // Haftalık ortalama

                                    // Aylık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_siparisler WHERE siparisler_olusturmatarihi >= CURDATE() - INTERVAL 1 MONTH";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $aylikOrtalama = $row->total / 30; // Aylık ortalama

                                    // Kontrol değişkeni
                                    $gunlukOrtalamaAktif = false;
                                    $haftalikOrtalamaAktif = false;
                                    $aylikOrtalamaAktif = false;

                                    if (isset($_POST['gunluk'])) {
                                        $gunlukOrtalamaAktif = true;
                                    } elseif (isset($_POST['haftalik'])) {
                                        $haftalikOrtalamaAktif = true;
                                    } elseif (isset($_POST['aylik'])) {
                                        $aylikOrtalamaAktif = true;
                                    }
                                    ?>
                                    <div>
                                        <div class="py-3 my-1">
                                            <?php
                                            if ($gunlukOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($gunlukOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($haftalikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($haftalikOrtalama, 2)

                                                    . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($aylikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($aylikOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } else {
                                                echo '<h4 class="mt-1 mb-0">' . number_format($totalVeriSayisi, 0, ',', '.') . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            }
                                            ?>
                                        </div>
                                        <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="gunluk" class="btn btn-link text-muted">Günlük</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="haftalik" class="btn btn-link text-muted">Haftalık</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="aylik" class="btn btn-link text-muted">Aylık</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="avatar">
                                        <span class="avatar-title bg-soft-success rounded">
                                            <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                        </span>
                                    </div>
                                    <p class="text-muted mt-4 mb-0">Yeni Müşteriler</p>
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM viento_musteriler";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $totalVeriSayisi = $row->total;

                                    // Günlük sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_musteriler WHERE musteriler_olusturmatarihi >= CURDATE()";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $gunlukOrtalama = $row->total / 1; // Günlük ortalama

                                    // Haftalık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_musteriler WHERE musteriler_olusturmatarihi >= CURDATE() - INTERVAL 7 DAY";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $haftalikOrtalama = $row->total / 7; // Haftalık ortalama

                                    // Aylık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_musteriler WHERE musteriler_olusturmatarihi >= CURDATE() - INTERVAL 1 MONTH";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $aylikOrtalama = $row->total / 30; // Aylık ortalama

                                    // Kontrol değişkeni
                                    $gunlukOrtalamaAktif = false;
                                    $haftalikOrtalamaAktif = false;
                                    $aylikOrtalamaAktif = false;

                                    if (isset($_POST['gunluk'])) {
                                        $gunlukOrtalamaAktif = true;
                                    } elseif (isset($_POST['haftalik'])) {
                                        $haftalikOrtalamaAktif = true;
                                    } elseif (isset($_POST['aylik'])) {
                                        $aylikOrtalamaAktif = true;
                                    }
                                    ?>
                                    <div>
                                        <div class="py-3 my-1">
                                            <?php
                                            if ($gunlukOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($gunlukOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($haftalikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($haftalikOrtalama, 2)

                                                    . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($aylikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($aylikOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } else {
                                                echo '<h4 class="mt-1 mb-0">' . number_format($totalVeriSayisi, 0, ',', '.') . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            }
                                            ?>
                                        </div>
                                        <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="gunluk" class="btn btn-link text-muted">Günlük</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="haftalik" class="btn btn-link text-muted">Haftalık</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="aylik" class="btn btn-link text-muted">Aylık</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="avatar">
                                        <span class="avatar-title bg-soft-primary rounded">
                                            <i class="mdi mdi-rocket-outline text-primary font-size-24"></i>
                                        </span>
                                    </div>
                                    <p class="text-muted mt-4 mb-0">Yeni Ürünler</p>
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM viento_urunler";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $totalVeriSayisi = $row->total;

                                    // Günlük sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_urunler WHERE urunler_olusturmatarihi >= CURDATE()";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $gunlukOrtalama = $row->total / 1; // Günlük ortalama

                                    // Haftalık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_urunler WHERE urunler_olusturmatarihi >= CURDATE() - INTERVAL 7 DAY";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $haftalikOrtalama = $row->total / 7; // Haftalık ortalama

                                    // Aylık sipariş ortalaması
                                    $query = "SELECT COUNT(*) as total FROM viento_urunler WHERE urunler_olusturmatarihi >= CURDATE() - INTERVAL 1 MONTH";
                                    $stmt = $link->prepare($query);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_object();
                                    $aylikOrtalama = $row->total / 30; // Aylık ortalama

                                    // Kontrol değişkeni
                                    $gunlukOrtalamaAktif = false;
                                    $haftalikOrtalamaAktif = false;
                                    $aylikOrtalamaAktif = false;

                                    if (isset($_POST['gunluk'])) {
                                        $gunlukOrtalamaAktif = true;
                                    } elseif (isset($_POST['haftalik'])) {
                                        $haftalikOrtalamaAktif = true;
                                    } elseif (isset($_POST['aylik'])) {
                                        $aylikOrtalamaAktif = true;
                                    }
                                    ?>
                                    <div>
                                        <div class="py-3 my-1">
                                            <?php
                                            if ($gunlukOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($gunlukOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($haftalikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($haftalikOrtalama, 2)

                                                    . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } elseif ($aylikOrtalamaAktif) {
                                                echo '<h4 class="mt-1 mb-0">' . round($aylikOrtalama, 2) . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            } else {
                                                echo '<h4 class="mt-1 mb-0">' . number_format($totalVeriSayisi, 0, ',', '.') . '<sup class="text-success fw-medium font-size-14"></sup></h4>';
                                            }
                                            ?>
                                        </div>
                                        <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="gunluk" class="btn btn-link text-muted">Günlük</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="haftalik" class="btn btn-link text-muted">Haftalık</button>
                                                </form>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post">
                                                    <button type="submit" name="aylik" class="btn btn-link text-muted">Aylık</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>



                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                                <h3 class="text-black mb-0">Yeni Siparişler</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <div class="position-relative">
                                            <form method="post" action="index.php">
                                                <input type="text" name="search" class="form-control" placeholder="Ara...">


                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <a href="ecommerce-checkout.php"><button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Yeni Sipariş Ekle</button></a>

                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <!--   <th style="width: 20px;" class="align-middle">
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                                        <label class="form-check-label" for="checkAll"></label>
                                                    </div>
                                                </th> -->
                                                <th class="align-middle">Sipariş Kodu</th>
                                                <th class="align-middle">Müşteri Adı</th>
                                                <th class="align-middle">Tarih</th>
                                                <!--  <th class="align-middle">Toplam</th> -->
                                                <th class="align-middle">Ödeme Durumu</th>
                                                <!-- <th class="align-middle">Ödeme Metodu</th>  -->
                                                <th class="align-middle">Detayı Görüntüle/Düzenle</th>
                                                <th class="align-middle">Aksiyon</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            /* make search */
                                            $search = isset($_POST['search']) ? $_POST['search'] : '';
                                            $query = "SELECT * FROM viento_siparisler WHERE siparisler_id LIKE '%$search%' OR siparisler_musterilerisim LIKE '%$search%'";

                                            $stmt = $link->prepare($query);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($siparis = $res->fetch_object()) {
                                                $siparis_kodu = $siparis->siparisler_id;
                                                $musteri_adi = $siparis->siparisler_musterilerisim;
                                                $tarih = $siparis->siparisler_olusturmatarihi;
                                                $odeme_durumu = $siparis->siparisler_siparisdurum;

                                            ?>
                                                <tr>
                                                    <!-- <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkOrder_<?php echo $siparis_kodu; ?>">
                                                            <label class="form-check-label" for="checkOrder_<?php echo $siparis_kodu; ?>"></label>
                                                        </div>
                                                    </td> -->
                                                    <td><?php echo $siparis_kodu; ?></td>
                                                    <td><?php echo $musteri_adi; ?></td>


                                                    <td><?php echo $tarih; ?></td>
                                                    <td><?php echo $odeme_durumu; ?></td>

                                                    <td>
                                                        <a href="ecommerce-edit-orders.php?update=<?php echo $siparis_kodu; ?>" class="btn btn-info btn-sm">
                                                            Detayları Görüntüle ve Düzenle
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="ecommerce-orders.php?delete=<?php echo $siparis_kodu; ?>" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a>

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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<!-- Chart JS -->
<script src="assets/js/pages/chartjs.js"></script>

<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>