<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

    <head>
        
        <title><?php echo $language["SweetAlert_2"]; ?> | Symox - Admin & Dashboard Template</title>

        <?php include 'layouts/head.php'; ?>

        <!-- Sweet Alert-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

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
                            $maintitle = "Extended";
                            $title = 'SweetAlert 2';
                        ?>
                        <?php include 'layouts/breadcrumb.php'; ?>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Examples</h4>
                                        <p class="card-title-desc">A beautiful, responsive, customizable
                                            and accessible (WAI-ARIA) replacement for JavaScript's popup boxes. Zero
                                            dependencies.</p>
                                    </div>
                                    <div class="card-body">
        
                                        <div class="row text-center">
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A basic message</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-basic">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A title with a text under</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-title">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A success message!</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A warning message, with a function attached to the "Confirm"-button...</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-warning">Click me</button>
                                                </div>
                                            </div>
        
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>By passing a parameter, you can execute something else for "Cancel".</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-params">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A message with custom Image Header</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-image">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A message with auto close timer</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-close">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>Custom HTML description and buttons</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="custom-html-alert">Click me</button>
                                                </div>
                                            </div>
        
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A custom positioned dialog</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-position">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <div class="p-3">
                                                    <p>A message with custom width, padding and background</p>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="custom-padding-width-alert">Click me</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-2">
                                                <p>Ajax request example</p>
                                                <button type="button" class="btn btn-primary waves-effect waves-light" id="ajax-alert">Click me</button>
                                            </div>
        
                                        </div> <!-- end row -->
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                                              
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

        <!-- Sweet Alerts js -->
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="assets/js/pages/sweet-alerts.init.js"></script>

        <script src="assets/js/app.js"></script>

    </body>
</html>
