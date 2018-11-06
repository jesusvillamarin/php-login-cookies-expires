<?php
//index.php

if (!isset($_COOKIE["type"])) {
    header("location:views/login.php");
}

?>
