<?php

include_once '/home/imagiweb/domains/imagiwebtion.eu/public_html/sklep/model/model.php';

class OrdersModel extends Model
{
    CONST SHOP_ACCOUNT = "10000001";
    CONST PAGE_BACK = "https://imagiwebtion.eu/sklep/index.php?task=users&action=orders";
    
    public function isOrderProceeding($userId)
    {
        $query = "SELECT * FROM summarized_carts";
    }
    public function createOrderId($userId)
    {
        $query = "INSERT INTO orders (user_id) VALUES ('$userId')";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $id = $this->pdo->lastInsertId();
        return $id;
    }
    
    public function createOrderProducts($orderId, $products)
    {
        foreach ($products as $productId => $properties)
        {
            $amount = $properties['amount'];
            $price = $properties['price'];
            $query = "INSERT INTO order_products (order_id, product_id, amount, price) VALUES ('$orderId', '$productId', '$amount', '$price')";
            $stmt = $this->pdo->query($query);
        }
    }
    
    public function createOrdersStatus($orderId)
    {
        $date = $this->getCurrentDateTime();
        $query = "INSERT INTO order_status (order_id, status, date) VALUES ('$orderId', '1', '$date')";
        $stmt = $this->pdo->query($query);
    }
    
    public function createOrder($cartInfo, $userId)
    {
        var_dump($cartInfo);
        $id = $this->createOrderId($userId);
        $transactionId = $this->generatePaymentHeader($id, $cartInfo['value']);
        $products = json_decode($cartInfo['products'], TRUE);
        $this->createOrderProducts($id, $products);
        $this->createOrdersStatus($id);
        
        return $transactionId;
    }
    
    public function getPaymentMethods()
    {
        $query = "SELECT * FROM payment_methods";
        $pms = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetchAll();
        return $pms;
    }
    
    public function getPaymentMethod($pmId)
    {
        $query = "SELECT * FROM payment_methods WHERE id='$pmId'";
        $pm = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        return $pm;
    }
    
    public function generatePaymentHeader($orderId, $value)
    {
        $data = ['account' => self::SHOP_ACCOUNT, 'title' => $orderId, 'value' => $value, 'pageBack' => self::PAGE_BACK];
        $jsonEncoded = json_encode($data);
        return base64_encode(openssl_encrypt($jsonEncoded, 'AES-128-CBC', 'abcdef'));
    }
    
    public function getOrderDetails($orderId)
    {
        $userDataQuery = "SELECT u.user_id, u.first_name, u.last_name, u.email, ud.street, ud.building_no, ud.apartment_no, ud.postal_code, ud.city, os.status FROM orders o"
                . " LEFT JOIN users u"
                . " ON o.user_id = u.user_id"
                . " LEFT JOIN users_data ud"
                . " ON u.user_id = ud.user_id"
                . " LEFT JOIN order_status os"
                . " ON o.order_id = os.order_id"
                . " WHERE o.order_id='$orderId'";
        $userData = $this->pdo->query($userDataQuery, PDO::FETCH_ASSOC)->fetch();
        
        $output = ['firstName' => $userData['first_name'],
            'lastName' => $userData['last_name'],
            'email' => $userData['email'],
            'street' => $userData['street'],
            'buildingNo' => $userData['building_no'],
            'apartmentNo' => $userData['apartment_no'],
            'postalCode' => $userData['postal_code'],
            'city' => $userData['city'],
            'status' => $userData['status']
            ];

        $orderProductsQuery = "SELECT * FROM orders o"
                . " LEFT JOIN order_products op"
                . " ON o.order_id = op.order_id"
                . " LEFT JOIN products p"
                . " ON op.product_id = p.product_id"
                . " WHERE o.order_id = '$orderId'";
        
        $orderedProducts = $this->pdo->query($orderProductsQuery, PDO::FETCH_ASSOC)->fetchAll();
       
        $totalPrice = 0;
        $products = [];
        foreach ($orderedProducts as $product)
        {
            $products[$product['product_id']] = ['name' => $product['product_name'], 'amount' => $product['amount'], 'price' => $product['price'], 'totalPrice' => $product['amount']*$product['price']];
            $totalPrice += $product['amount']*$product['price'];
        }
        
        $output['products'] = $products;
        $output['totalPrice'] = $totalPrice;
        return $output;
    }
    
    public function getOrderProductIds($orderId)
    {
        $orderProductsQuery = "SELECT product_id FROM order_products"
                . " WHERE order_id = '$orderId'";
        
        $orderedProducts = $this->pdo->query($orderProductsQuery, PDO::FETCH_ASSOC)->fetchAll();
        return $orderedProducts;
    }
    
    public function getUserOrders($userId)
    {
        $query = "SELECT *, SUM((op.amount*op.price)) as total_price, SUM(op.amount) as total_amount FROM orders o"
                . " LEFT JOIN order_products op"
                . " INNER JOIN order_status os"
                . " ON op.order_id = os.order_id"
                . " ON o.order_id = op.order_id"
                . " LEFT JOIN order_statuses oss"
                . " ON os.status = oss.status_id"
                . " WHERE o.user_id = '$userId'"
                . " GROUP BY o.order_id";
        $orders = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetchAll();
        
        return $orders;
    }
    
    public function getAllOrdersByStatus($status = FALSE)
    {
        if ($status)
        {
            $statusPart = " WHERE os.status = '$status'";
        }
        else
        {
            $statusPart = "";
            
            echo "<p>NO DATA</p>";
        }
        
        $query = "SELECT *, SUM((op.amount*op.price)) as total_price, SUM(op.amount) as total_amount FROM orders o"
            . " LEFT JOIN order_products op"
            . " INNER JOIN order_status os"
            . " ON op.order_id = os.order_id"
            . " INNER JOIN order_statuses oss ON os.status = oss.status_id"
            . " ON o.order_id = op.order_id"
            . $statusPart
            . " GROUP BY o.order_id";
        $orders = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetchAll();
        return $orders;
    }
    
    public function changeOrderStatus($orderId, $status)
    {
        $query = "UPDATE order_status SET status='$status' WHERE order_id = '$orderId'";
        if ($this->pdo->query($query))
        {
            $this->sendOrderStatusMail($orderId, $this->getOrderStatusName($status));
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function sendOrderStatusMail($orderId, $status)
    {
        $orderEmailAddressQuery = "SELECT u.email FROM orders o"
                . " LEFT JOIN users u"
                . " ON o.user_id = u.user_id"
                . " WHERE o.order_id = '$orderId'";
        $orderEmailAddress = $this->pdo->query($orderEmailAddressQuery, PDO::FETCH_ASSOC)->fetch()['email'];
        //$emailAddress = $orderEmailAddress['email'];
        mail($orderEmailAddress, "Zmiana statusu zamówienia", "Twoje zamówienie nr $orderId zmieniło swój status na $status");
    }
    
    public function getOrderStatuses()
    {
        $orderStatuses = [];
        $query = "SELECT * FROM order_statuses";
        $orderStatusesData = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetchAll();
        foreach ($orderStatusesData as $orderStatus)
        {
            $orderStatuses[$orderStatus['status_id']] = $orderStatus['status_name'];
        }
        return $orderStatuses;
    }
    
    public function getOrderStatusName($statusId)
    {
        $query = "SELECT status_name FROM order_statuses WHERE status_id = '$statusId'";
        $statusName = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch()['status_name'];
        return $statusName;

    }
    
}