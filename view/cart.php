<?php

include 'view/view.php';

class CartView extends View
{
    public function addToCart()
    {
        $productId = $_POST['productId'];
        $amount = $_POST['amount'];
        $this->set('productId', $productId);
        $data = $this->cartModel->addToCart($this->get('userId'), $productId, $amount);
        $cart = $this->cartModel->getCartSummary($this->get('userId'));
        $this->set("totalCartAmount", $cart['totalAmount']);
        $this->set("totalCartValue", $cart['totalValue']);
        if ($data)
        {
            $this->render('cartAddProductSuccess');
        }
        else
        {      
            $this->render('cartAddProductFail');
        }
    }
    
    public function cartSummary()
    {
        $cartItems = $this->cartModel->getCart(Session::get('userId'));
        $productsModel = $this->loadModel('products');
        $cartItemsDetailed = $productsModel->getSummaryForCart($cartItems);
        $cartItemsShort = $productsModel->getSummaryForCartShort($cartItems);
        $this->set('cart', $cartItemsDetailed);
        $this->cartModel->checkTemporaryCart($this->get('userId'));
        $this->cartModel->createTemporaryCart($this->get('userId'),$cartItemsShort);
        $this->render('cartSummary');
    }
    
    public function cartOrder()
    {
        $usersModel = $this->loadModel('users');
        $carriersModel = $this->loadModel('carriers');
        $ordersModel = $this->loadModel('orders');
        
        $this->set('userData', $usersModel -> getUserData($this->get('userId')));
        $this->set('carriers', $carriersModel -> getCarriersInfo());
        $this->set('paymentMethods', $ordersModel->getPaymentMethods());
        
        $this->render('cartOrder');
    }
    
    public function summarizeOrder()
    {
        $carriersModel = $this->loadModel('carriers');
        $ordersModel = $this->loadModel('orders');
        if ($this->cartModel->getTemporaryCart($this->get('userId')))
        {
            $cartInfo = $this->cartModel->getTemporaryCart($this->get('userId'));
            $transactionId = $ordersModel->createOrder($cartInfo, $this->get('userId'));
            $this->cartModel->clearTemporaryCart($this->get('userId'));
            $this->set('transactionId', $transactionId);
            
            $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $street = $_POST['street'];
        $buildingNumber = $_POST['buildingNumber'];
        $apartmentNumber = $_POST['apartmentNumber'];
        $postalCode = $_POST['postalCode'];
        $city = $_POST['city'];
        $carrier = $_POST['carrier'];
        $paymentMethod = $_POST['payment'];
        
        $this->set('paymentMethod', $ordersModel->getPaymentMethod($paymentMethod)['name']);
        $this->set('paymentAddress', $ordersModel->getPaymentMethod($paymentMethod)['address']);
        
        $carrierInfo = $carriersModel->getCarrierInfo($carrier);
        
        $userData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'street' => $street,
            'buildingNumber' => $buildingNumber,
            'apartmentNumber' => $apartmentNumber,
            'postalCode' => $postalCode,
            'city' => $city,
            'carrier' => $carrier,
            'carrierName' => $carrierInfo['name'],
            'carrierCost' => $carrierInfo['cost'],
            'totalPrice' => $carrierInfo['cost'] + $cartInfo['value']
            ];
        
            $this->set('userData', $userData);
        
            $this->render('summarizeOrder');
        }
        else
        {
            $this->set('content', 'Nie posiadasz aktywnego koszyka!');
            $this->render('dataError');
        }
        
        
    }
}
?>
