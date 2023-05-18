<?php
include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM  viento_musteriler  WHERE  musteriler_id = ?";
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
    $query = "SELECT * FROM viento_musteriler WHERE musteriler_isim LIKE '%$search%' OR musteriler_telefon LIKE '%$search%' OR musteriler_eposta LIKE '%$search%'";
} else {
    $query = "SELECT * FROM viento_musteriler ORDER BY musteriler_olusturmatarihi DESC";
}
$stmt = $link->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

?>



<head>

    <title><?php echo $language["Customers"]; ?> Viento</title>

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
                $maintitle = "Viemto";
                $title = 'Müşteriler';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <div class="search-box me-2 mb-2 d-inline-block">
                                            <div class="position-relative">
                                                <form method="post" action="ecommerce-customers.php">
                                                    <input type="text" name="search" class="form-control" placeholder="Ara...">
                                                <i class="bx bx-search-alt search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                           <a href="ecommerce-add-customer.php">
                                             <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Yeni Müşteri Ekle</button>
                                           </a>
                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Müşteri ID</th>
                                                <th>Müşteri Adı</th>
                                                <th>Gsm/Eposta</th>
                                                <th>Vergi No</th>
                                                <th>Vergi Dairesi</th>
                                                <th>Kdv Oranı</th>
                                                <th>Adres</th>


                                           
                                                <th>Aksiyon</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $query = isset($_POST['search']) ? "SELECT * FROM viento_musteriler WHERE musteriler_isim LIKE '%$search%' OR musteriler_telefon LIKE '%$search%' OR musteriler_eposta LIKE '%$search%'" : "SELECT * FROM viento_musteriler ORDER BY musteriler_olusturmatarihi DESC";
                                           $stmt = $link->prepare($query);
                                           $stmt->execute();
                                           $res = $stmt->get_result();
                                           while ($cust = $res->fetch_object())  {
                                            ?>
                                                <tr>

                                                    <td><?php echo $cust->musteriler_id; ?></td>

                                                    <td><?php echo $cust->musteriler_isim; ?></td>
                                                    <td>
                                                        <p class="mb-1"><?php echo $cust->musteriler_telefon; ?></p>
                                                        <p class="mb-1"><?php echo $cust->musteriler_eposta; ?></p>

                                                    </td>

                                                    <td><?php echo $cust->musteriler_vergino; ?></td>

                                                    <td><?php echo $cust->musteriler_vergidairesi; ?></td>
                                                    <td><?php echo $cust->musteriler_kdv; ?></td>
                                                    <td><?php echo $cust->musteriler_teslimat; ?></td>
                                                   
                                                    <td>

                                                        <a href="ecommerce-edit-customer.php?update=<?php echo $cust->musteriler_id; ?>" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Düzenle</a>
                                                        <a  href="ecommerce-customers.php?delete=<?php echo $cust->musteriler_id; ?>" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a>

                                                    </td>
                                                </tr>

                                        </tbody>
                                    <?php } ?>
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