<?php

class Registration
{
    /**
     * @var object $connect The database connection
     */
    private $connect = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["registrar"])) {
            $this->registerNewUser();
        }
    }

  
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Usuario vacio";
        } elseif (empty($_POST['user_password']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Contraseña vacia";
        } elseif ($_POST['user_password'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Las contraseñas no son las mismas";
        } elseif (strlen($_POST['user_password']) < 6) {
            $this->errors[] = "La contraseña mínimo es de 6 caracteres";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "El usuario debe ser mayor a 2 caracteres y menor a 64";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "El usuario no cumple las reglas";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Debe introducir un correo";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "El correo electrónico no debe ser mayor a 64 carácteres";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Tu correo electrónico no tiene un formato válido";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password'] === $_POST['user_password_repeat'])
        ) {
            // create a database connection
           $this->connect = new mysqli("localhost","root","","login");

            // change character set to utf8 and check it
            if (!$this->connect->set_charset("utf8")) {
                $this->errors[] = $this->connect->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->connect->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->connect->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->connect->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password'];

                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM user_details WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->connect->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Lo siento, usuario ya existente";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO user_details (user_email, user_password, user_name, user_type, user_image, user_status)
                            VALUES('" . $user_email . "', '" . $user_password_hash . "', '" . $user_name . "', 'user', 'image.jpg', 'active');";
                    $query_new_user_insert = $this->connect->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Tu cuenta a sido creada exitosamente, ya puedes logearte.";
                    } else {
                        $this->errors[] = "Lo siento tu registro fallo, intentelo de nuevo";
                    }
                }
            } else {
                $this->errors[] = "Lo siento, en este momento no se puede registrar";
            }
        } else {
            $this->errors[] = "Error desconocido";
        }
    }
}
