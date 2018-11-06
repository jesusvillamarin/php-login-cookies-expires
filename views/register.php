<?php
// show potential errors / feedback (from registration object)

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
            <div class="panel-heading">Registro</div>
            <div class="panel-body">
               <span>
               <?php
                 if (isset($registration)) {
                    if ($registration->errors) {
                        foreach ($registration->errors as $error) {
                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                        }
                    }
                    if ($registration->messages) {
                        foreach ($registration->messages as $message) {
                            echo "<div class='alert alert-danger'>" . $message . "</div>";
                        }
                    }
                }
                ?>
                </span>
            <div class="panel-body">
               <div class="row">
               <form method="post" action="registrarse.php" name="registerform">
                     <div class="form-group col-xs-6">
                        <label>Usuario</label>
                        <input type="text" name="user_name" id="user_name" class="form-control"/>
                     </div>
                     <div class="form-group col-xs-6">
                        <label>Correo Electronico</label>
                        <input type="text" name="user_email" id="user_email" class="form-control" />
                     </div>
                     <div class="form-group col-xs-6">
                        <label>Contraseña</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" />
                     </div>
                     <div class="form-group col-xs-6">
                        <label>Repite contraseña</label>
                        <input type="password" name="user_password_repeat" id="user_password_repeat" class="form-control" />
                     </div>
                     <div class="form-group col-xs-6">
                        <input type="submit" name="registrar" id="registrar" class="btn btn-primary" value="Registrar" />
                        <a name="regresar" id="regresar" class="btn btn-warning" href="index.php" role="button">Regresar</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <br />
      </div>
   </body>
</html>