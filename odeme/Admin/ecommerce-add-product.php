<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');
include('config/checklogin.php');


if (isset($_POST['urunekle'])) {
    //Prevent Posting Blank Values



    /* Buraya */
    if (empty($_POST["urunadi"])) {
        echo '<script type="text/javascript">';
        echo 'alert("Ürün Adı Boş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunkdv"])) {
        echo '<script type="text/javascript">';
        echo 'alert("kdvBoş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunstok"])) {
        echo '<script type="text/javascript">';
        echo 'alert("stokBoş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunilkfiyat"])) {
        echo '<script type="text/javascript">';
        echo 'alert("ilk fiyat Boş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunanakategori"])) {
        echo '<script type="text/javascript">';
        echo 'alert("kategori Boş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunaltkategori"])) {
        echo '<script type="text/javascript">';
        echo 'alert("alt kateori Boş Bırakılamaz");';
        echo '</script>';
    } else if (empty($_POST["urunaciklama"])) {
        echo '<script type="text/javascript">';
        echo 'alert("acıklama Boş Bırakılamaz");';
        echo '</script>';
    } /* else if (empty($_FILES['prod_img'])) {
            echo '<script type="text/javascript">';
            echo 'alert("resim Boş Bırakılamaz");';
            echo '</script>';
        }  */ else {
        //Getting Values from URL
        $urunler_id = $_POST['urunkodu'];
        $urunler_isim = $_POST['urunadi'];
        $urunler_kod = $_POST['urunkodu'];
        $urunler_kdv = $_POST['urunkdv'];
        $urunler_stok = $_POST['urunstok'];
        $urunler_anakategori = $_POST['urunanakategori'];
        $urunler_altkategori = $_POST['urunaltkategori'];
        $urunler_sonfiyat = $_POST['urunsonfiyat'];

        $urunler_resim = $_FILES['urunler_resim']['name']; // Dosyanın adını alın

        $uploadsDirectory = '/odeme/Admin/assets/img/products/'; // Dosyanın yükleneceği dizini belirtin

        $targetFilePath = $_SERVER['DOCUMENT_ROOT'] . $uploadsDirectory . $urunler_resim; // Hedef dosya yolunu oluşturun

        move_uploaded_file($_FILES['urunler_resim']['tmp_name'], $targetFilePath); // Dosyayı sunucuya yükleyin


        $urunler_aciklama = $_POST['urunaciklama'];




        //Insert Captured information to a database table
        $postQuery = "INSERT INTO viento_urunler (urunler_id,urunler_kod, urunler_isim , urunler_resim , urunler_stok ,urunler_sonfiyat ,urunler_kdv , urunler_anakategori ,urunler_altkategori , urunler_aciklama) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $postStmt = $link->prepare($postQuery);
        //bind paramaters

        // bind paramaters
        $rc = $postStmt->bind_param('ssssssssss', $urunler_id, $urunler_kod, $urunler_isim, $urunler_resim, $urunler_stok, $urunler_sonfiyat, $urunler_kdv, $urunler_anakategori, $urunler_altkategori, $urunler_aciklama);


        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt->affected_rows > 0) {
            /* make alert */
            echo '<script type="text/javascript">';
            echo 'alert("Kayıt Başarılı");';
            echo '</script>';

            echo "<script>window.location.href ='ecommerce-products.php'</script>";
        } else {
            /* $err = "Please Try Again Or Try Later"; */
            echo '<script type="text/javascript">';
            echo 'alert("Kayıt Başarısız");';
            echo '</script>';
        }
    }
}

// Ana kategorileri al
$anaKategorilerSorgu = "SELECT anakategori_id, anakategori_isim FROM viento_anakategori";
$anaKategorilerSonuc = $link->query($anaKategorilerSorgu);

// Alt kategorileri al
$altKategorilerSorgu = "SELECT altkategori_id, altkategori_isim, anakategori_id FROM viento_altkategori";
$altKategorilerSonuc = $link->query($altKategorilerSorgu);




?>

<head>

    <title><?php echo $language["Add_Product"]; ?>Viento</title>

    <?php include 'layouts/head.php'; ?>

    <!-- choices css -->
    <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <!-- dropzone css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>
    <script>
        function calculateSalePrice() {
            // Giriş fiyatını ve KDV'yi al
            var girdiFiyat = parseFloat(document.getElementById("urunilkfiyat").value);
            var kdvOrani = parseFloat(document.getElementById("urunkdv").value);

            // KDV miktarını hesapla
            var kdvMiktari = (girdiFiyat * kdvOrani) / 100;

            // Satış fiyatını hesapla ve input alanına yaz
            var satisFiyat = girdiFiyat + kdvMiktari;
            document.getElementById("urunsonfiyat").value = satisFiyat.toFixed(2);
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
                $title = 'Ürün Ekle';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="addproduct-accordion" class="custom-accordion">
                            <div class="card">
                                <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                                    <div class="p-4">

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Ürün Bilgisi</h5>
                                                <p class="text-muted text-truncate mb-0">Aşağıdaki tüm bilgileri doldurun</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>

                                        </div>

                                    </div>
                                </a>

                                <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                    <div class="p-4 border-top">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label class="form-label" for="urunadi">Ürün Adı</label>
                                                <input id="urunadi" name="urunadi" placeholder="Ürün Adını Girin" type="text" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">

                                                    <div class="mb-3">
                                                        <label class="form-label" for="urunkodu">Stok Kodu</label>
                                                        <input type="text" id="urunkodu" name="urunkodu" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="" readonly>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="choices-single-specifications" class="form-label">Kdv Oranı</label>
                                                        <select class="form-control" data-trigger name="urunkdv" id="urunkdv" onchange="calculateSalePrice()">
                                                            <option value="1">Tevkifatlı %1</option>
                                                            <option value="8">%8</option>
                                                            <option value="18">%18</option>

                                                        </select>


                                                    </div>
                                                </div>
                                                <div class="col-lg-2">

                                                    <div class="mb-3">
                                                        <label class="form-label" for="urunstok">Stok Adeti</label>

                                                        <input id="urunstok" name="urunstok" placeholder="Stok Adetini Girin" type="number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="urunilkfiyat">Giriş Fiyatı</label>
                                                        <input id="urunilkfiyat" name="urunilkfiyat" placeholder="Giriş Fiyatını Seçin" type="number" class="form-control" oninput="calculateSalePrice()">


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label">Ana Kategori</label>
                                                        <select class="form-control" data-trigger name="urunanakategori" id="urunanakategori">
                                                            <option value="">Seçiniz</option>
                                                            <?php
                                                            // Ana kategorileri döngüye alarak seçenekleri oluşturun
                                                            $anaKategorilerSorgu = "SELECT anakategori_id, anakategori_isim FROM viento_anakategori";
                                                            $anaKategorilerSonuc = $link->query($anaKategorilerSorgu);
                                                            

                                                            while ($anaKategori = $anaKategorilerSonuc->fetch_assoc()) {
                                                                echo '<option value="' . $anaKategori['anakategori_id'] . '">' . $anaKategori['anakategori_isim'] . '</option>';
                                                            }
                                                            ?>
                                                         
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label">Alt Kategori</label>
                                                        <select class="form-control" data-trigger name="urunaltkategori" id="urunaltkategori">
                                                            <option value="">Seçiniz</option>
                                                            <?php
                                                            $altKategorilerSorgu = "SELECT altkategori_id, altkategori_isim, anakategori_id FROM viento_altkategori";
                                                            $altKategorilerSonuc = $link->query($altKategorilerSorgu);

                                                            // Alt kategorileri döngüye alarak seçenekleri oluşturun
                                                            while ($altKategori = $altKategorilerSonuc->fetch_assoc()) {
                                                                echo '<option value="' . $altKategori['altkategori_id'] . '">' . $altKategori['altkategori_isim'] . '</option>';
                                                            }
                                                            ?>


                                                        </select>
                                                    </div>
                                                </div>
                                         



                                                <!-- 
                                                 <div class="mb-3">
                                                    <label for="choices-single-default" class="form-label">Category</label>
                                                            <button type="button" class="btn btn-outline-secondary waves-effect">Secondary</button>
                                                    </div>
                                                
                                                -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="urunsonfiyat">Satış Fiyatı</label>
                                                        <input id="urunsonfiyat" name="urunsonfiyat" value="0" placeholder="Satış Fiyatı" type="number" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <label class="form-label" for="urunresmi">Ürünün Resmi</label>
                                                <!-- <input type="file" name="urunresmi" class="btn btn-outline-success form-control" value=""> -->
                                                <input type="file" name="urunler_resim" id="" class="btn btn-outline-success form-control" value="">
                                            </div>
                                            <br>
                                            <div class="mb-0">
                                                <label class="form-label" for="urunaciklama">Ürün Açıklaması</label>
                                                <textarea class="form-control" id="urunaciklama" name="urunaciklama" placeholder="Açıklama Girin" rows="4"></textarea>
                                            </div>
                                            <br>
                                            <div class="row mb-4">
                                                <div class="col text-end">


                                                    <input type="submit" name="urunekle" value="Ürün Ekle" class="btn btn-success" value="">
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </form>
                                    </div>
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

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- dropzone plugin -->
<script src="assets/libs/dropzone/min/dropzone.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/ecommerce-choices.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>