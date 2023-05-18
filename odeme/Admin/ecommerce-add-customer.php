<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');
include('config/checklogin.php');


if (isset($_POST['musteriekle'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["musteriid"]) || empty($_POST["musteriadi"]) || empty($_POST['musterieposta']) || empty($_POST['musterigsm']) || empty($_POST['musterivergino']) || empty($_POST['musterivergidairesi']) || empty($_POST['musterikdv'])    || empty($_POST['musterisifre']) || empty($_POST['musteriteslimat'])) {

        /* Buraya */
        echo '<script type="text/javascript">';
        echo 'alert("Lütfen tüm alanları doldurunuz.");';
        echo '</script>';
    } else {
        $musteriler_id = $_POST['musteriid'];
        $musteriler_isim = $_POST['musteriadi'];
        $musteriler_telefon = $_POST['musterigsm'];
        $musteriler_eposta = $_POST['musterieposta'];
        $musteriler_sifre = sha1(md5($_POST['musterisifre']));
        $musteriler_vergino = $_POST['musterivergino'];
        $musteriler_vergidairesi = $_POST['musterivergidairesi'];
        $musteriler_kdv = $_POST['musterikdv'];
        $musteriler_teslimat = $_POST['musteriteslimat'];
        $musteriler_sehir = $_POST['musterisehri'];
        $musteriler_ilce = $_POST['musteriilce'];
        $musteriler_postakodu = $_POST['musteripostakodu'];
        /* show all  */
        // echo $musteriler_id . $musteriler_isim . $musteriler_telefon . $musteri_eposta . $musteriler_sifre . $musteriler_vergino . $musteriler_vergidairesi . $musteriler_teslimat;

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO viento_musteriler (musteriler_id, musteriler_isim, musteriler_telefon , musteriler_eposta,musteriler_sifre,musteriler_vergino, musteriler_vergidairesi,musteriler_kdv,musteriler_teslimat,musteriler_sehir,musteriler_ilce,musteriler_zip) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $postStmt = $link->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssssssssssss', $musteriler_id, $musteriler_isim, $musteriler_telefon, $musteriler_eposta, $musteriler_sifre, $musteriler_vergino, $musteriler_vergidairesi,$musteriler_kdv, $musteriler_teslimat ,$musteriler_sehir,$musteriler_ilce,$musteriler_postakodu);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            /* make alert */
            echo '<script type="text/javascript">';
        echo 'alert("Kayıt Başarılı");';
        echo '</script>';
        /* go to ecommerce-customers page */
        echo "<script>window.location.href ='ecommerce-customers.php'</script>";

           
        } else {
            /* $err = "Please Try Again Or Try Later"; */
        }
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
                $title = 'Müşteri Ekle';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="p-4 border-top">
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <!-- if (empty($_POST["musteriid"]) || empty($_POST["musteriadi"]) || empty($_POST['musterieposta']) || empty($_POST['musterigsm']) || empty($_POST['musterivergino']) || empty($_POST['musterivergidairesi'])    || empty($_POST['musterisifre']) || empty($_POST['musteriteslimat']) ) { -->
                                                <label class="form-label" for="musteriid">Müşteri Kodu</label>
                                              
                                                <input type="text" name="musteriid" class="form-control" value="<?php echo $alpha; ?>-<?php echo $beta; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musteriadi">Müşteri Adı</label>
                                                <input id="musteriadi" name="musteriadi" placeholder="Müşteri Adını Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musterieposta">Müşteri Eposta</label>
                                                <input id="musterieposta" name="musterieposta" placeholder="Müşteri Eposta Adresini Girin" type="email" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musterigsm">Müşteri GSM</label>
                                                <input id="musterigsm" name="musterigsm" placeholder="Müşterinin Telefon Numarasını Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musterivergino">Müşteri Vergi No</label>
                                                <input id="musterivergino" name="musterivergino" placeholder="Müşteri Vergi No Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                        <div class="mb-3">
                                                        <label for="musterivergidairesi" class="form-label">Vergi Dairesi</label>
                                                        <select class="form-control" data-trigger name="musterivergidairesi" id="musterivergidairesi">
                                                            <option value="">Select</option>
                                                            <option value="Ankara">Ankara</option>
                                                            <option value="İstanbul">İstanbul</option>
                                                            <option value="İzmir">İzmir</option>
                                                        </select>
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <!-- description --><div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musterisifre">Müşteri Şifresi</label>
                                                <input id="musterisifre" name="musterisifre" placeholder="Müşteri Şifresini Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="mb-3">
                                                        <label for="musterikdv" class="form-label">Kdv Oranı</label>
                                                        <select class="form-control" data-trigger name="musterikdv" id="musterikdv">
                                                            <option value="">Select</option>
                                                            <option value="Tevkifatlı 1">Tevkifatlı %1</option>
                                                            <option value="8">%8</option>
                                                            <option value="18">%18</option>
                                                        </select>
                                                    </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musterisehri">Şehir</label>
                                                <input id="musterisehri" name="musterisehri" placeholder="Şehir Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                       



                                    </div>
                                    <div class="row">
                                        
                                        <!-- description -->
                                        <div class="col-md-4">
                                        <div class="mb-3">
                                                        <label for="musteriilce" class="form-label">İlçe</label>
                                                      
                                                        <input id="musteriilce" name="musteriilce" placeholder="İlçe Girin" type="text" class="form-control" value="">
                                                    </div>
                                                    
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="musteripostakodu">Posta Kodu</label>
                                                <input id="musteripostakodu" name="musteripostakodu" placeholder="Posta Kodu Girin" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label" for="musteriteslimat">Teslimat Adresi</label>
                                            <input id="musteriteslimat" name="musteriteslimat" placeholder="Tesliamt Adresi Girin" type="text" class="form-control" value="">
                                        </div>



                                    </div>
                                    <br>
                                    <div class="row md-4">
                                        <div class="col text-end">

                                            <input type="submit" name="musteriekle" value="Müşteri Ekle" class="btn btn-success" value="">
                                        </div> <!-- end col -->
                                    </div>


                                </form>
                            </div>



                        </div>





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