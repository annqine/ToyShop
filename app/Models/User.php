<?php
require_once __DIR__ . '/../Core/Model.php';
class User extends Model
{
    public function userExists($username)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function register($username, $password)
    {
        //$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password, is_admin) VALUES (:username, :password, 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        return $stmt->execute();
    }
    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['password'] === $password) {
                return $user;
            } else {
                return false;
            }
        }
        return false;
    }
}
