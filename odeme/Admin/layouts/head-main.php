<?php
// include language configuration file based on selected language
$lang = "en";
if (isset($_GET['lang'])) {
    $lang = "en";
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = "en";
}else {
    
}
require_once ("./assets/lang/" . $lang . ".php");

?>
<!DOCTYPE html>

<html lang="<?php echo $lang ?>">