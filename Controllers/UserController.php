<?php
require("../CONFIG.php");
require_once($GLOBALS["path"] . '/Models/UserModel.php');

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function registerUser($username, $email, $password, $poblacio, $adreca, $codi_postal)
    {
        // Aquí puedes agregar validaciones adicionales si es necesario

        // Verificar la existencia de los campos necesarios
        if ($username && $email && $password && $poblacio && $codi_postal && $adreca) {
            $result = $this->userModel->createUser($username, $email, $password, $poblacio, $adreca, $codi_postal);

            if ($result) {
                // Usuario registrado con éxito
                // Puedes redirigir a una página de éxito
                header("Location: /");
                exit();
            } else {
                // Error al registrar el usuario
                // Puedes redirigir a una página de error
                header("Location: /Registro");
                exit();
            }
        } else {
            // Campos faltantes, manejar el error
            echo "Error: Campos faltantes en el formulario de registro.";
        }
    }

    public function login()
    {
        // Verifica que se hayan enviado datos de inicio de sesión
        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo "Por favor, proporciona tanto el correo electrónico como la contraseña.";
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->loginUser($email, $password);

        if ($user !== false) {
            // Inicio de sesión exitoso, puedes almacenar información del usuario en la sesión
            session_start();
            $_SESSION['user'] = $user;

            // Redirigir a una página después del inicio de sesión exitoso
            header("Location: home.php");
            exit;
        } else {
            // Inicio de sesión fallido, mostrar un mensaje de error
            echo "Inicio de sesión fallido. Verifica tus credenciales.";
        }
    }
}
