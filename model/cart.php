<?php

include_once 'model/model.php';

class CartModel extends Model
{
    /**
     * Taka funkcja
     * @param Int $userId Id of user
     * @return Array Array of sth
     */
    public function getCart($userId)
    {
        $output = [];
        $query = "SELECT * FROM cart_items WHERE user_id='$userId'";
        $items=$this->pdo->query($query, PDO::FETCH_ASSOC);
        foreach ($items as $item)
        {
            $output[$item['item_id']] = $item['amount'];
        }
        return $output;
    }
    private function checkProductInCart($userId, $productId)
    {
        $query = "SELECT amount FROM cart_items WHERE user_id='$userId' AND item_id='$productId'";
        $amount = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        if ($amount)
        {
            return $amount['amount'];
        }
        else
        {
            return FALSE;
        }
    }
    public function addToCart($userId, $productId, $amount)
    {
        if (filter_var($amount, FILTER_VALIDATE_INT)===FALSE)
        {
            return FALSE;
        }
        $currentAmount = $this->checkProductInCart($userId, $productId);
        if ($currentAmount)
        {
            $newAmount = $currentAmount + $amount;
            $query = "UPDATE cart_items SET amount='$newAmount' WHERE user_id='$userId' AND item_id='$productId'";
            if ($this->pdo->query($query))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            $query = "INSERT INTO cart_items (user_id, item_id, amount) VALUES ('$userId','$productId','$amount')";
            if ($this->pdo->query($query))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }
    public function getCartSummary($userId)
    {
        $cart = $this->getCart($userId);
        $totalAmount = 0;
        $totalValue = 0;
        foreach ($cart as $item=>$amount)
        {
            $query = "SELECT price FROM products WHERE product_id='$item'";
            $price = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
            $totalAmount += $amount;
            $totalValue += ($amount*$price['price']);
        }
        return ['totalAmount' => $totalAmount, 'totalValue' => $totalValue];
    }
    
    public function getCartDetailedSummary($userId)
    {
        $summary = [];
        $cart = $this->getCart($userId);
        foreach ($cart as $item=>$amount)
        {
        }
    }
    
    public function checkTemporaryCart($userId)
    {
        $query = "SELECT * FROM summarized_carts WHERE user_id='$userId'";
        $user = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        if ($user)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function createTemporaryCart($userId,$cart)
    {
        $date = $this->getCurrentDateTime();
        $totalValue = 0;
        $temporaryCart = json_encode($cart['products']);
        $temporaryCartValue = $cart['totalPrice'];
        if ($this->checkTemporaryCart($userId))
        {
            $query = "UPDATE summarized_carts SET products='$temporaryCart', value='$temporaryCartValue', date='$date' WHERE user_id='$userId'";
            $this->pdo->query($query);
        }
        else
        {
            $query = "INSERT into summarized_carts (user_id, products, value, date) VALUES ('$userId', '$temporaryCart', '$temporaryCartValue', '$date')";
            $this->pdo->query($query);
        }
    }
    
    public function getTemporaryCart($userId)
    {
        $query = "SELECT * FROM summarized_carts WHERE user_id='$userId'";
        $user = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        if ($user)
        {
            return $user;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function clearTemporaryCart($userId)
    {
        $query = "DELETE FROM summarized_carts WHERE user_id='$userId'";
        $stmt = $this->pdo->query($query);
        $query = "DELETE FROM cart_items WHERE user_id='$userId'";
        $stmt = $this->pdo->query($query);
    }
}