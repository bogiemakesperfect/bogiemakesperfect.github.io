<?php


include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM  viento_urunler  WHERE  urunler_id = ?";
    $stmt = $link->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
    } else {
    }
}
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM viento_urunler WHERE urunler_isim LIKE '%$search%' OR urunler_kod LIKE '%$search%'";
} else {
    $query = "SELECT * FROM viento_urunler ORDER BY urunler_olusturmatarihi DESC";
}
$stmt = $link->prepare($query);
$stmt->execute();
$res = $stmt->get_result();



?>



<head>

    <title><?php echo $language["Products"]; ?>Viento</title>

    <?php include 'layouts/head.php'; ?>

    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="assets/libs/nouislider/nouislider.min.css">


    <?php include 'layouts/head-style.php'; ?>
    <script>
        function filterByCategory() {
            var selectedCategoryId = document.getElementById("anakategori").value;
            var url = "ecommerce-products.php?anakategori=" + selectedCategoryId;
            window.location.href = url;
        }
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
                $title = 'Ürünler';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12 col-lg-4">


                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">

                                    <div class="card-header">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="col-sm-8">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <form method="post" action="ecommerce-products.php">
                                                            <input type="text" name="search" class="form-control" placeholder="Ara...">
                                                            <i class="bx bx-search-alt search-icon"></i>
                                                    </div>

                                                    <!--   <div class="btn-group mb-2 d-none d-sm-inline-block">

                                                        <select id="anakategori" class="form-select" onchange="filterByCategory()" >
                                                            <option value="">Tüm Kategoriler</option>
                                                            <?php
                                                            $ret = "SELECT * FROM viento_anakategori";
                                                            $stmt = $link->prepare($ret);
                                                            $stmt->execute();
                                                            $res = $stmt->get_result();

                                                            while ($kat = $res->fetch_object()) {
                                                            ?>
                                                                <option value="<?php echo $kat->anakategori_id; ?>"><?php echo $kat->anakategori_isim; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <select id="altkategori" class="form-select"></select> -->

                                                </div>
                                                <!-- make -->
                                            </div>
                                            <div class="ms-auto">
                                                <a href="ecommerce-add-product.php"> <button type="button" class="btn btn-success waves-effect waves-light">Ürün Ekle</button></a>

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

                                                        <th>Stok Adeti</th>
                                                        <th>Kdv</th>
                                                        <th>Ana/Alt Kategori</th>
                                                        <th>Fiyat</th>
                                                        <th>Düzenle</th>
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
                                                            <td><?php echo $prod->urunler_stok; ?></td>
                                                            <td><?php echo $prod->urunler_kdv; ?></td>
                                                            <td>
                                                                <?php
                                                                $anakatid = $prod->urunler_anakategori;
                                                                $query2 = "SELECT * FROM viento_anakategori WHERE anakategori_id = ?";
                                                                $stmt2 = $link->prepare($query2);
                                                                $stmt2->bind_param('s', $anakatid);
                                                                $stmt2->execute();
                                                                $res2 = $stmt2->get_result();
                                                                $anakat = $res2->fetch_object();
                                                                echo $anakat->anakategori_isim;
                                                                $stmt2->close();
                                                                ?>
                                                                /

                                                                <?php
                                                                $altkatid = $prod->urunler_altkategori;
                                                                $query2 = "SELECT * FROM viento_altkategori WHERE altkategori_id = ?";
                                                                $stmt2 = $link->prepare($query2);
                                                                $stmt2->bind_param('s', $altkatid);
                                                                $stmt2->execute();
                                                                $res2 = $stmt2->get_result();
                                                                $altkatid = $res2->fetch_object();
                                                                echo $altkatid->altkategori_isim;
                                                                $stmt2->close();
                                                                ?>

                                                            </td>
                                                            <td><?php echo $prod->urunler_sonfiyat; ?></td>
                                                            <td>
                                                                <a href="ecommerce-edit-product.php?update=<?php echo $prod->urunler_id; ?>" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Düzenle</a>
                                                                <a href="ecommerce-products.php?delete=<?php echo $prod->urunler_id; ?>" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a>
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

<!-- nouisliderribute js -->
<script src="assets/libs/nouislider/nouislider.min.js"></script>
<script src="assets/libs/wnumb/wNumb.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/product-filter-range.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>