<?php
//login.php

include("../DB/db_conex.php");

if (isset($_COOKIE["type"])) {
    header("location:logeado.php");
}

$message = '';

if (isset($_POST["login"])) {
    if (empty($_POST["user_email"]) || empty($_POST["user_password"])) {
        $message = "<div class='alert alert-danger'>Ambos campos son requeridos </div>";
    } else {
        $query = "SELECT * FROM user_details WHERE user_email = :user_email";
        $statement = $connect->prepare($query);
        $statement->execute(array(
            'user_email' => $_POST["user_email"]
        ));
        $count = $statement->rowCount();
        if ($count > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                if (password_verify($_POST["user_password"], $row["user_password"])) {
                    setcookie("type", $row["user_type"], time() + 10, "/", "");
                    session_start();
                    $_SESSION["user_email"] = $_POST["user_email"];
                    header("location:logeado.php");
                } else {
                    $message = '<div class="alert alert-danger">Contraseña incorrecta</div>';
                }
            }
        } else {
            $message = "<div class='alert alert-danger'>Correo incorrecto</div>";
        }
    }
}


?>

<!DOCTYPE html>
<html>
   <head>
      <title>Gitsito </title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
      <br />
      <div class="container">
         <h2 align="center">Gitsito account</h2>
         <br />
         <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
               <span>
               <?php
                  echo $message;
                ?>
                </span>
               <form method="post">
                  <div class="form-group">
                     <label>Correo Electronico</label>
                     <input type="text" name="user_email" id="user_email" class="form-control" />
                  </div>
                  <div class="form-group">
                     <label>Contraseña</label>
                     <input type="password" name="user_password" id="user_password" class="form-control" />
                  </div>
                  <div class="form-group">
                     <input type="submit" name="login" id="login" class="btn btn-primary" value="Login" />
                     <a name="registrarse" id="registrarse" class="btn btn-warning" href="../registrarse.php" role="button">Registrarme </a>
                  </div>
               </form>
            </div>
         </div>
         <br />
      </div>
   </body>
</html>