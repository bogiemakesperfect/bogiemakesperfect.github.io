<?php
session_start();
unset($_SESSION['id']);
session_destroy();
header("Location: ../../odeme/admin/auth-login.php");
exit;
