<?php
//logout.php
setcookie("type", "", time() - 3600, "/", "");
session_abort();
header("location:index.php");

?>