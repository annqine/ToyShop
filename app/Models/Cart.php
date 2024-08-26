<?php
require_once __DIR__ . '/../Core/Model.php';

class Cart extends Model
{
    public function addToCart($userId, $toyId, $quantity)
    {
        $sql = "INSERT INTO cart (user_id, toy_id, quantity) VALUES (:user_id, :toy_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':toy_id', $toyId);
        $stmt->bindValue(':quantity', $quantity);
        return $stmt->execute();
    }

    public function getCart($userId)
    {
        $sql = "SELECT c.*, t.name_toys, t.price FROM cart c
                JOIN all_toys t ON c.toy_id = t.id
                WHERE c.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function removeFromCart($userId, $toyId)
    {
        $sql = "DELETE FROM cart WHERE user_id = :user_id AND toy_id = :toy_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':toy_id', $toyId);
        return $stmt->execute();
    }
    public function clearCart($userId)
    {
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        return $stmt->execute();
    }
}
