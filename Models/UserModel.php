<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        // Configura los parámetros de conexión a PostgreSQL
        $host = 'localhost';
        $dbname = 'sneeaking';
        $user = 'postgres';
        $pass = 'root';

        // Conecta a la base de datos PostgreSQL
        try {
            $this->db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function createUser($username, $email, $password, $poblacio = null, $adreca, $codi_postal = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO usuaris (nom, Correu_electronic, password, poblacio, adreca, Codi_postal, temps_creacio) VALUES (:username, :email, :password, :poblacio, :adreca, :codi_postal, NOW())";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":poblacio", $poblacio, PDO::PARAM_STR);
        $stmt->bindParam(":adreca", $adreca, PDO::PARAM_STR);
        $stmt->bindParam(":codi_postal", $codi_postal, PDO::PARAM_STR);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $stmt->errorInfo()[2]);
        }

        return $result;
    }


    public function showUsers()
    {
        $query = "SELECT * FROM usuaris";
        $result = $this->db->query($query);

        $users = $result->fetchAll(PDO::FETCH_ASSOC);

        print_r($users);
        return $users;
    }

    public function loginUser($email, $password)
    {
        $query = "SELECT * FROM usuaris WHERE Correu_electronic = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // La contraseña es correcta, almacena toda la información del usuario en la sesión
            session_start();
            $_SESSION['user'] = $user;

            return $user;
        } else {
            // La contraseña es incorrecta o el usuario no existe
            return false;
        }
    }
}
