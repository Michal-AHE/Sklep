<?php

include_once 'model/model.php';

class CarriersModel extends Model
{
    public function getCarriersInfo()
    {
        $query = "SELECT * FROM carriers";
        $carriers=$this->pdo->query($query, PDO::FETCH_ASSOC)->fetchAll();
        return $carriers;
    }
    
    public function getCarrierInfo($carrierId)
    {
        $query = "SELECT * FROM carriers WHERE carrier_id = '$carrierId'";
        $carrier = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        return $carrier;
    }
}