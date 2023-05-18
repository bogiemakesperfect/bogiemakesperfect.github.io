<?php
include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $adn = "delete from viento_siparisler where siparisler_id=?";
    $stmt = $link->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Sipariş Silindi');</script>";
    echo "<script>window.location.href = 'ecommerce-orders.php';</script>";
}
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM viento_siparisler WHERE siparisler_id LIKE '%$search%' OR siparisler_musterilerisim LIKE '%$search%'";
} else {
    $query = "SELECT * FROM viento_siparisler ORDER BY siparisler_olusturmatarihi DESC";
}
$stmt = $link->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

?>


<head>

    <title><?php echo $language["Orders"]; ?> Viento</title>

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
                $maintitle = "Viento";
                $title = 'Siparişler';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <div class="position-relative">
                                            <form method="post" action="ecommerce-orders.php">
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