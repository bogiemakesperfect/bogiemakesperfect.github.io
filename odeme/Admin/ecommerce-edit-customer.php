<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');
include('config/checklogin.php');

if (isset($_POST['updateCustomer'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["musteriadi"]) || empty($_POST['musterieposta']) || empty($_POST['musterigsm']) || empty($_POST['musterivergidairesi']) || empty($_POST['musterikdv']) ||   empty($_POST['musterisifre']) || empty($_POST['siparisler_sehir']) || empty($_POST['billing-ilce']) || empty($_POST['zip-code']))  {
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
        $sehir = $_POST['siparisler_sehir'];
        $ilce = $_POST['billing-ilce'];
        $zip = $_POST['zip-code'];
        $update = $_GET['update'];

        //Insert Captured information to a database table
        $postQuery = "UPDATE viento_musteriler SET musteriler_isim =?, musteriler_telefon =?, musteriler_eposta =?, musteriler_sifre =?, musteriler_vergino =?, musteriler_vergidairesi =?, musteriler_kdv =?, musteriler_teslimat =?, musteriler_sehir =? , musteriler_ilce =? ,musteriler_zip =?  WHERE  musteriler_id =?";
        $postStmt = $link->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssssssssssss', $musteriler_isim, $musteriler_telefon, $musteriler_eposta, $musteriler_sifre, $musteriler_vergino, $musteriler_vergidairesi, $musteriler_kdv, $musteriler_teslimat , $sehir ,$ilce ,$zip, $update);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            echo "<script>window.location.href ='ecommerce-customers.php'</script>";
        } else {
        }
    }
}


?>

<head>

    <title>Müşteri Düzenle</title>

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
                $title = 'Müşteri Düzenle';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <?php

                        $update = $_GET['update'];
                        $ret = "SELECT * FROM  viento_musteriler WHERE musteriler_id = '$update' ";
                        $stmt = $link->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($cust = $res->fetch_object()) {
                        ?>
                            <div class="card">

                                <div class="p-4 border-top">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <!-- if (empty($_POST["musteriid"]) || empty($_POST["musteriadi"]) || empty($_POST['musterieposta']) || empty($_POST['musterigsm']) || empty($_POST['musterivergino']) || empty($_POST['musterivergidairesi'])    || empty($_POST['musterisifre']) || empty($_POST['musteriteslimat']) ) { -->
                                                    <label class="form-label" for="musteriid">Müşteri Kodu</label>

                                                    <input type="text" name="musteriid" class="form-control" value="<?php echo $cust->musteriler_id; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="musteriadi">Müşteri Adı</label>
                                                    <input type="text" name="musteriadi" value="<?php echo $cust->musteriler_isim; ?>" class="form-control">

                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="musterieposta">Müşteri Eposta</label>
                                                    <input id="musterieposta" name="musterieposta" placeholder="Müşteri Eposta Adresini Girin" type="email" class="form-control" value="<?php echo $cust->musteriler_eposta; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="musterigsm">Müşteri GSM</label>
                                                    <input id="musterigsm" name="musterigsm" placeholder="Müşterinin Telefon Numarasını Girin" type="text" class="form-control" value="<?php echo $cust->musteriler_telefon; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="musterivergino">Müşteri Vergi No</label>
                                                    <input id="musterivergino" name="musterivergino" placeholder="Müşteri Vergi No Girin" type="text" class="form-control" value="<?php echo $cust->musteriler_vergino; ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="musterivergidairesi" class="form-label">Vergi Dairesi</label>
                                                    <select class="form-control" data-trigger name="musterivergidairesi" id="musterivergidairesi">
                                                        <option value=""><?php echo $cust->musteriler_vergidairesi; ?></option>
                                                        <option value="Ankara">Ankara</option>
                                                        <option value="İstanbul">İstanbul</option>
                                                        <option value="İzmir">İzmir</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-4 mb-lg-0">
                                                    <label class="form-label">Şehir</label>
                                                    <input type="text" class="form-control" id="siparisler_sehir" name="siparisler_sehir" placeholder="Şehir Girin" value="<?php echo $cust->musteriler_sehir; ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4 mb-lg-0">
                                                    <label class="form-label" for="billing-ilce">İlçe</label>
                                                    <input type="text" class="form-control" id="billing-ilce" name="billing-ilce" placeholder="İlçe Girin" value="<?php echo $cust->musteriler_ilce; ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-0">
                                                    <label class="form-label" for="zip-code">Posta kodu</label>
                                                    <input type="text" class="form-control" id="zip-code" name="zip-code" placeholder="Posta Kodunu Girin" value="<?php echo $cust->musteriler_zip; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">

                                            <!-- description -->
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="musterisifre">Müşteri Şifresi</label>
                                                    <input id="musterisifre" name="musterisifre" placeholder="Müşteri Şifresini Girin" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="musterikdv" class="form-label">Kdv Oranı</label>
                                                    <select class="form-control" data-trigger name="musterikdv" id="musterikdv">
                                                        <option value=""><?php echo $cust->musteriler_kdv; ?></option>
                                                        <option value="Tevkifatlı 1">Tevkifatlı %1</option>
                                                        <option value="8">%8</option>
                                                        <option value="18">%18</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label" for="musteriteslimat">Teslimat Adresi</label>
                                                <textarea class="form-control" id="musteriteslimat" name="musteriteslimat" placeholder="Teslimat Adresi Girin" rows="2" value=""><?php echo $cust->musteriler_isim; ?></textarea>
                                            </div>



                                        </div>
                                        <br>
                                        <div class="row md-4">
                                            <div class="col text-end">

                                                <input type="submit" name="updateCustomer" value="Müşteriyi Güncelle" class="btn btn-success" value="">
                                            </div> <!-- end col -->
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