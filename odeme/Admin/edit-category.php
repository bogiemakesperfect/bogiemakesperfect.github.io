<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');
include('config/checklogin.php');

if (isset($_POST['update'])) {
    //Prevent Posting Blank Values
    if ($_POST["anakategori_isim"] === "") {
        $err = "Boş Değer Gönderemezsiniz";
    } else {
        $anakategori_id = $_GET['update'];
        $anakategori_isim = $_POST['anakategori_isim'];
    

        $query = "UPDATE viento_anakategori SET anakategori_isim = ? WHERE anakategori_id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("si", $anakategori_isim, $anakategori_id);
        $stmt->execute();

        echo "<script>window.location.href ='Category.php'</script>";
    }
}


?>

<head>

    <title><?php echo $language["Add_Product"]; ?> Viento</title>

    <?php include 'layouts/head.php'; ?>

    <!-- choices css -->
    <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <!-- dropzone css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />

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
                $title = 'Kategori Düzenle';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <?php

                        $update = $_GET['update'];
                        $ret = "SELECT * FROM  viento_anakategori WHERE anakategori_id = '$update' ";
                        $stmt = $link->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($cust = $res->fetch_object()) {

                        ?>

                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-secondary btn-lg" ><?php echo $cust->anakategori_isim; ?></button>
                                    <!-- <a href="Category.php?deleteana=<?php echo $cust->anakategori_id; ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a> -->
                                </div>
                            <div class="card-body">
                                
                                <form  method="post">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="anakategori_isim" name="anakategori_isim" placeholder="Ana Kategori İsmi Gir" value="<?php echo $cust->anakategori_isim; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="d-grid">
                                            <button type="submit" name="update" class="btn btn-primary">İsmini Değiştir</button>
                                        </div>
                                    </div>
                                </div>
                                    
                                
                                    
                                    
                                    </form>
                                </div>
                                </div>
                                </form>
                               
                            </div>
                                 

                            </div>

                        <?php } ?>




                    </div>
                </div>
                <!-- end row -->

                <!-- end row-->


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

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- dropzone plugin -->
<script src="assets/libs/dropzone/min/dropzone.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/ecommerce-choices.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>