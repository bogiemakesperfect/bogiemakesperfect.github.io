<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include('config/code-generator.php');
include('config/checklogin.php');


if (isset($_POST['createana'])) {
    //Prevent Posting Blank Values



    /* Buraya */
    if (empty($_POST["anakategori_isim"])) {
    } /* else if (empty($_FILES['prod_img'])) {
            echo '<script type="text/javascript">';
            echo 'alert("resim Boş Bırakılamaz");';
            echo '</script>';
        }  */ else {
        //Getting Values from URL
        $anakategori_isim = $_POST['anakategori_isim'];







        //Insert Captured information to a database table
        $postQuery = "INSERT INTO viento_anakategori (anakategori_isim) VALUES(?)";
        $postStmt = $link->prepare($postQuery);
        //bind paramaters

        // bind paramaters
        $rc = $postStmt->bind_param('s', $anakategori_isim);


        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt->affected_rows > 0) {
            /* make alert */
            echo '<script type="text/javascript">';
            echo 'alert("Kayıt Başarılı");';
            echo '</script>';

            echo "<script>window.location.href ='Category.php'</script>";
        } else {
            /* $err = "Please Try Again Or Try Later"; */
            echo '<script type="text/javascript">';
            echo 'alert("Kayıt Başarısız");';
            echo '</script>';
        }
    }
}
if (isset($_POST['createalt'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["altkategori_isim"])) {
        // Alt kategori adı boş ise bir hata mesajı gösterilebilir veya gerekli işlemler yapılabilir.
    } else {
        //Getting Values from URL
        $altkategori_isim = $_POST['altkategori_isim'];
        $anakategori_id = $_POST['anakategori_id']; // Ana kategori ID'sini formdan alın veya gerekli yere göre elde edin

        // Insert Captured information to a database table
        $postQuery = "INSERT INTO viento_altkategori (altkategori_isim, anakategori_id) VALUES(?, ?)";
        $postStmt = $link->prepare($postQuery);
        // Bind parameters
        $rc = $postStmt->bind_param('si', $altkategori_isim, $anakategori_id);

        $postStmt->execute();
        // Declare a variable which will be passed to alert function
        if ($postStmt->affected_rows > 0) {
            /* make alert */
            echo '<script type="text/javascript">';
            echo 'alert("Alt Kategori Kaydedildi");';
            echo '</script>';

            echo "<script>window.location.href ='Category.php'</script>";
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Alt Kategori Kaydedilemedi");';
            echo '</script>';
        }
    }
}

if (isset($_GET['deleteana'])) {
    $id = $_GET['deleteana'];

    // Ürünlerin silinmesi
    $deleteUrunQuery = "DELETE FROM viento_urunler WHERE urunler_altkategori IN (SELECT altkategori_id FROM viento_altkategori WHERE anakategori_id = ?)";
    $deleteUrunStmt = $link->prepare($deleteUrunQuery);
    $deleteUrunStmt->bind_param('s', $id);
    $deleteUrunStmt->execute();
    $deleteUrunStmt->close();

    // Alt kategorilerin silinmesi
    $deleteAltQuery = "DELETE FROM viento_altkategori WHERE anakategori_id = ?";
    $deleteAltStmt = $link->prepare($deleteAltQuery);
    $deleteAltStmt->bind_param('s', $id);
    $deleteAltStmt->execute();
    $deleteAltStmt->close();

    // Ana kategori silme işlemi
    $deleteQuery = "DELETE FROM viento_anakategori WHERE anakategori_id = ?";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param('s', $id);
    $deleteStmt->execute();
    $deleteStmt->close();

    if ($deleteStmt) {
        echo "<script>alert('Kategori Silindi');</script>";
        echo "<script>window.location.href ='Category.php'</script>";
    } else {
        echo "<script>alert('Silme İşlemi Başarısız');</script>";
        echo "<script>window.location.href ='Category.php'</script>";
    }
}



if (isset($_GET['deletealt'])) {
    $id = $_GET['deletealt'];

    // Alt kategoriye ait ürünlerin silinmesi
    $deleteUrunQuery = "DELETE FROM viento_urunler WHERE urunler_altkategori = ?";
    $deleteUrunStmt = $link->prepare($deleteUrunQuery);
    $deleteUrunStmt->bind_param('s', $id);
    $deleteUrunStmt->execute();
    $deleteUrunStmt->close();

    // Alt kategori silme işlemi
    $deleteQuery = "DELETE FROM viento_altkategori WHERE altkategori_id = ?";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param('s', $id);
    $deleteStmt->execute();
    $deleteStmt->close();

    if ($deleteStmt) {
        echo "<script>alert('Alt Kategori Silindi');</script>";
        echo "<script>window.location.href ='Category.php'</script>";
    } else {
        echo "<script>alert('Silme İşlemi Başarısız');</script>";
        echo "<script>window.location.href ='Category.php'</script>";
    }
}





?>

<head>

    <title>Kategoriler | Viento - Admin</title>

    <?php include 'layouts/head.php'; ?>

    <!-- choices css -->
    <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <!-- dropzone css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                $title = 'Kategoriler';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="col">
                    <div class="card">
                        <?php
                        $ret = "SELECT * FROM viento_anakategori";
                        $stmt = $link->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($kat = $res->fetch_object()) {
                        ?>
                            <div class="card-body">
                                <div class="button-group">
                                    <button type="button" class="btn btn-secondary btn-lg" onclick="openPopup()"><?php echo $kat->anakategori_isim; ?></button>
                                    <a href="edit-category.php?update=<?php echo $kat->anakategori_id; ?>"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Düzenle</a>
                                    <a href="Category.php?deleteana=<?php echo $kat->anakategori_id; ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a>
                                    <button type="button" class="btn btn-primary waves-effect waves-light w-sm toggle-alt-kategoriler">Alt Kategorileri Göster</button>
                                </div>
                            </div>

                            <div class="card-body alt-kategoriler" style="display: none;">
                                <?php
                                $altRet = "SELECT * FROM viento_altkategori WHERE anakategori_id = ?";
                                $altStmt = $link->prepare($altRet);
                                $altStmt->bind_param("i", $kat->anakategori_id);
                                $altStmt->execute();
                                $altRes = $altStmt->get_result();

                                while ($altKat = $altRes->fetch_object()) {
                                ?>
                                    <div class="button-group mb-2">
                                        <button type="button" class="btn btn-outline-primary waves-effect waves-light"><?php echo $altKat->altkategori_isim; ?></button>
                                        <a href="edit-altcategory.php?update=<?php echo $altKat->altkategori_id; ?>"><i class="mdi  font-size-16 text-danger me-1"></i> Düzenle</a>
                                        <a href="Category.php?deletealt=<?php echo $altKat->altkategori_id; ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Sil</a>
                                    </div>
                                <?php } ?>

                                <div class="button-group">
                                    <form method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="altkategori_isim" placeholder="Alt Kategori Eklemek İçin İsim Gir" required>
                                            <input type="hidden" name="anakategori_id" value="<?php echo $kat->anakategori_id; ?>">
                                            <button type="submit" name="createalt" class="btn btn-success waves-effect waves-light">Alt Kategori Ekle</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                        <?php } ?>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h5 class="card-title">Ana Kategori Oluştur</h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="anakategori_isim" name="anakategori_isim" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="d-grid">
                                            <button type="submit" name="createana" class="btn btn-primary">Ana Kategori Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <script>
                    $(document).ready(function() {
                        $(".toggle-alt-kategoriler").click(function() {
                            $(this).closest(".card-body").next(".alt-kategoriler").slideToggle();
                        });
                    });
                </script>






            </div>


        </div>


    </div>
</div>









<!-- end row -->

<!--  <div class="row mb-4">
                    <div class="col text-end">
                        <a href="#" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancel </a>
                        <a href="#" class="btn btn-success"> <i class=" bx bx-file me-1"></i> Save </a>
                    </div> 
                </div>
 -->

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