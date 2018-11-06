<?php 

require_once("DB/db_conex.php");
require_once("classes/Registration.php");

$registration = new Registration();

// show the register view (with the registration form, and messages/errors)
include("views/register.php");

?>