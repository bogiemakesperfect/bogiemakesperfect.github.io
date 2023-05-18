<?php
require_once "layouts/config.php";

// Check if the user is already logged in, if yes then redirect him to index page
session_start();


// Define variables and initialize with empty values
$user_email = $password = "";
$password_err = "";

// Pre-fill email input field with user's email
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_email = $_SESSION["email"];
    /* make alert*/
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT admin_id,admin_email,admin_password FROM viento_admin WHERE admin_email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $user_email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: index.php");
                            exit;
                        } else {

                            // Display an error message if password is not valid
                            $password_err = "Girdiğiniz şifre geçerli değil.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist

                    $email_err = "Bu e-posta ile hesap bulunamadı.";
                }
            } else {
                echo "Hata! Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<head>

    <title><?php echo $language["Lock_Screen"]; ?>Viento</title>

    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>

<div class="authentication-bg min-vh-100">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="d-flex flex-column min-vh-100 px-3 pt-4">
            <div class="row justify-content-center my-auto">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="text-center mb-4">

                        <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Viento</span>

                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Kilit Ekranı</h5>
                                <p class="text-muted">Ekranı açmak için lütfen şifrenizi girin!</p>
                            </div>
                            <div class="p-2 mt-4">
                                <div class="user-thumb text-center mb-4">
                                    <!--  <img src="assets/images/users/avatar-4.jpg" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail"> -->
                                    <h5 class="font-size-15 mt-3">Viento Admin</h5>
                                </div>
                                <form method="POST" action="">

                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <div class="float-end">
                                            <a href="auth-recoverpw.php" class="text-muted">Şifrenimi Unuttun?</a>
                                        </div>
                                        <label class="form-label" for="userpassword">Şifre</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" placeholder="Şifrenizi Girin">
                                        <span class="text-danger"><?php echo $password_err; ?></span>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Ekranı Aç</button>
                                    </div>

                                    <!-- <div class="mt-4 text-center">
                                            <p class="mb-0">Bu sen de<a href="auth-login.php" class="fw-medium text-primary"> Giriş Yap </a></p>
                                        </div> -->
                                </form>
                            </div>

                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center text-muted p-4">
                        <p class="text-white-50">© <script>
                                document.write(new Date().getFullYear())
                            </script> Viento</p>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->
</div>
<!-- end authentication section -->

<?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>