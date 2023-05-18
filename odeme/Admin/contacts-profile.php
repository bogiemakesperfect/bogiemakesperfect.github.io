<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>

    <title><?php echo $language["Profile"]; ?> | Symox - Admin & Dashboard Template</title>

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
                $title = 'Profil';
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row mb-4">
                    <div class="col-xl-12">
                       
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="profile-user"></div>
                            <div class="card-body">
                                <div class="profile-content text-center">
                                    <div class="profile-user-img">
                                        <img src="assets/images/users/avatar-viento.jpg" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h5 class="mt-3 mb-1">Admin</h5>
                                    <p class="text-muted">Viento Group</p>


                                    <p class="text-muted mb-1">
                                       lorem  ipsum lorem  ipsum lorem  ipsum lorem  ipsum lorem  ipsum lorem  ipsum lorem  ipsum </p>

                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Klinikler</h5>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap">
                                        <tbody>
                                           
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