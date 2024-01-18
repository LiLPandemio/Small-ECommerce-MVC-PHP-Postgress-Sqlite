<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $dbPath = $GLOBALS["path"] . "/db.db";
        $this->db = new SQLite3($dbPath);
    }

    public function createUser($username, $email, $password, $poblacio = null, $adreca, $codi_postal = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuaris (nom, Correu_electronic, password, poblacio, adreca, Codi_postal, temps_creacio) VALUES (:username, :email, :password, :poblacio, :adreca, :codi_postal, datetime('now'))";
        $stmt = $this->db->prepare($query);

        // Asegúrate de declarar las variables antes de usar bindParam
        $stmt->bindParam(":username", $username, SQLITE3_TEXT);
        $stmt->bindParam(":email", $email, SQLITE3_TEXT);
        $stmt->bindParam(":password", $hashedPassword, SQLITE3_TEXT);
        $stmt->bindParam(":poblacio", $poblacio, SQLITE3_TEXT);
        $stmt->bindParam(":adreca", $adreca, SQLITE3_TEXT);
        $stmt->bindParam(":codi_postal", $codi_postal, SQLITE3_TEXT);

        $result = $stmt->execute();

        if (!$result) {
            die("Error en la ejecución de la consulta: " . $this->db->lastErrorMsg());
        }

        return $result;
    }


    public function loginUser($email, $password)
    {
        $query = "SELECT * FROM usuaris WHERE Correu_electronic = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email, SQLITE3_TEXT);
        $result = $stmt->execute();

        $user = $result->fetchArray(SQLITE3_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // La contraseña es correcta, almacena toda la información del usuario en la sesión
            session_start();
            $_SESSION['user'] = $user[0];

            return $user;
        } else {
            // La contraseña es incorrecta o el usuario no existe
            return false;
        }
    }
}
