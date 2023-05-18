<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.php" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.svg" alt="" height="22"> 
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Viento</span>
            </span>
        </a>

        <a href="index.php" class="logo logo-light">
            <span class="logo-lg">
                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Viento</span>
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm.svg" alt="" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo $language["Menu"]; ?></li>

                <li>
                    <a href="index.php">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards"><?php echo $language["Dashboard"]; ?></span>
                        
                    </a>
                </li>
               
                 
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-add-product.php" id="topnav-dashboard" role="button" data-key="t-add-product" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <i class="bx bx-plus icon nav-icon"></i>
                        <span data-key="t-dashboards"><?php echo $language["Add_Product"]; ?></span>
                    </a>
                </li>
                <!-- Klinik Ekle -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-customers.php" id="topnav-dashboard" role="button" data-key="t-customers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <i class="bx bx-street-view icon nav-icon"></i>
                        <span data-key="t-dashboards"><?php echo $language["Customers"]; ?></span>
                    </a>
                </li>

                <!-- Siparil olustur -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-orders.php" id="topnav-dashboard" role="button" data-key="t-orders" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <i class="bx bx-shopping-bag icon nav-icon"></i>
                        <span data-key="t-dashboards"><?php echo $language["Orders"]; ?></span>
                    </a>
                </li>
                <!-- Ürünler -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-products.php" id="topnav-dashboard" role="button" data-key="t-products" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- make products icon -->

                        <i class="bx bx-box icon nav-icon"></i>
                        <span data-key="t-dashboards"><?php echo $language["Products"]; ?></span>
                    </a>
                </li>
                <!-- Kategori Oluştur -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="Category.php" id="topnav-category" role="button" data-key="t-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- make products icon -->

                        <i class="bx bx-collection icon nav-icon"></i>
                        <span data-key="t-category">Kategoriler</span>
                    </a>
                </li>
                <!-- Yeni Sipariş Oluştur -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-checkout.php" id="topnav-category" role="button" data-key="t-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- make products icon -->

                        <i class="bx bx-plus-circle icon nav-icon"></i>
                        <span data-key="t-category">Yeni Sipariş Oluştur</span>
                    </a>
                </li>
                <!-- Yeni Müşteri Olustur -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle arrow-none" href="ecommerce-add-customer.php" id="topnav-category" role="button" data-key="t-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- make products icon -->

                        <i class="bx bx-user-plus icon nav-icon"></i>
                        <span data-key="t-category">Yeni Müşteri Oluştur</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->