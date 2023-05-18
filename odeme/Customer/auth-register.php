<?php
// Include config file
require_once "layouts/config.php";
include('config/code-generator.php');;

// Define variables and initialize with empty values
$useremail = $username =  $password = $confirm_password = "";
$useremail_err = $username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate useremail
    if (empty(trim($_POST["useremail"]))) {
        $useremail_err = "Please enter a useremail.";
    } elseif (!filter_var($_POST["useremail"], FILTER_VALIDATE_EMAIL)) {
        $useremail_err = "Invalid email format";
    } else {
        // Prepare a select statement
        $sql = "SELECT musteriler_id FROM viento_musteriler WHERE musteriler_eposta = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_useremail);

            // Set parameters
            $param_useremail = trim($_POST["useremail"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $useremail_err = "This useremail is already taken.";
                } else {
                    $useremail = trim($_POST["useremail"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
            
        }
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["musteriid"]))) {
        $musteriler_id = "Please enter a username.";
    } else {
        $musteriler_id = trim($_POST["musteriid"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please enter a confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($useremail_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO viento_musteriler (musteriler_id,musteriler_eposta, musteriler_isim, musteriler_sifre, musteriler_token) VALUES (?,?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $musteriler_id, $param_useremail, $param_username, $param_password, $param_token);

            // Set parameters
            $param_useremail = $useremail;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_token = bin2hex(random_bytes(50)); // generate unique token

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: index.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<?php include 'layouts/head-main.php'; ?>

    <head>
    
        <title><?php echo $language["Register"]; ?> | Viento</title>

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
                            <a href="index.php">
                                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Viento</span>
                            </a>
                       </div>

                        <div class="card">
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Kayıt Ol</h5>
                                    <p class="text-muted">Yeni Hesap Oluştur</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form class="needs-validation custom-form mt-4 pt-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    
                                        <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                            <label class="form-label" for="useremail">Email</label>
                                            <input type="email" class="form-control" name="useremail" id="useremail" placeholder="Eposta adresini gir">  
                                            <span class="text-danger"><?php echo $useremail_err; ?></span>      
                                        </div>
                
                                        <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı adını gir">
                                            <span class="text-danger"><?php echo $username_err; ?></span>
                                        </div>
                
                                        <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                            <label class="form-label" for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" name="password" placeholder="Şifreni Gir">
                                            <span class="text-danger"><?php echo $password_err; ?></span>        
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                            <label class="form-label" for="userpassword">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" placeholder="Şifreni Onayla" name="confirm_password" value="<?php echo $confirm_password; ?>">
                                            <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="auth-terms-condition-check">
                                            <label class="form-check-label" for="auth-terms-condition-check"> <a href="javascript: void(0);" class="text-dark">Şartlar ve koşulları kabul ediyorum</a></label>
                                        </div>
                                        
                                        <div class="mt-3 text-end">
                                        <input type="hidden" name="musteriid" class="form-control" value="<?php echo $alpha; ?>-<?php echo $beta; ?>">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Kayıt Ol</button>
                                        </div>

                                      

                                        <div class="mt-4 text-center">
                                            <p class="text-muted mb-0">Hesabın Var mı ? <a href="auth-login.php" class="fw-medium text-primary"> Giriş Yap</a></p>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">© <script>document.write(new Date().getFullYear())</script> Viento</p>
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
