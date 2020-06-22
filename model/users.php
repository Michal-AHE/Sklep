<?php

include_once 'model/model.php';

class UsersModel extends Model
{
    /**
     * Taka funkcja
     * @param Int $userId Id of user
     * @return Array Array of sth
     */
    public function getUserData($userId)
    {
        $query = "SELECT u.first_name, u.last_name, ud.street, ud.building_no, ud.apartment_no, ud.postal_code, ud.city FROM users u LEFT JOIN users_data ud ON u.user_id=ud.user_id WHERE u.user_id='$userId'";
        $userData = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        return $userData;
    }
}