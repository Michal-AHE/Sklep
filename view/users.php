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
}
?>
