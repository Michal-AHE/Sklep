<?php

include 'view/view.php';

class UsersView extends View
{
    public function orders()
    {
        $ordersModel = $this->loadModel('orders');
        $orders = $ordersModel->getUserOrders($this->get('userId'));
        $this->set('orders', $orders);
        $this->render('usersOrders');
    }
    
    public function order()
    {
        $ordersModel = $this->loadModel('orders');
        $this->set('orderId', $_GET['orderId']);
        $order = $ordersModel->getOrderDetails($this->get('orderId'));
        $this->set('details', $order);
        //$this->set('orders', $orders);
        $this->render('usersOrder');
    }
}
?>
