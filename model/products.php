<?php

include_once '/home/imagiweb/domains/imagiwebtion.eu/public_html/sklep/model/model.php';

class ProductsModel extends Model{

    CONST IMAGE_PATH = "gfx/products/";
    
    public function getAll() {
        $query="SELECT * FROM products";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data[]=$row;
        }
        $select->closeCursor();

        return $data;
    }
    public function getOne($id) {
        $query="SELECT * FROM products WHERE product_id='$id'";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data[]=$row;
        }
        $select->closeCursor();

        return $data;
    }
    public function insert($data) {
        $ins=$this->pdo->prepare('INSERT INTO articles (title, content, date_add, autor, id_categories) VALUES (
            :title, :content, :date_add, :autor, :id_categories)');
        $ins->bindValue(':title', $data['title'], PDO::PARAM_STR);
        $ins->bindValue(':content', $data['content'], PDO::PARAM_STR);
        $ins->bindValue(':date_add', $data['date_add'], PDO::PARAM_STR);
        $ins->bindValue(':autor', $data['author'], PDO::PARAM_STR);
        $ins->bindValue(':id_categories', $data['cat'], PDO::PARAM_INT);
        $ins->execute();
    }
    public function delete($id) {
        $del=$this->pdo->prepare('DELETE FROM articles where id=:id');
        $del->bindValue(':id', $id, PDO::PARAM_INT);
        $del->execute();
    }
    
    public function getLatestProducts($limit = 5)
    {
        $query="SELECT * FROM products ORDER BY product_id DESC LIMIT $limit";
        $select=$this->pdo->query($query, PDO::FETCH_ASSOC);
        foreach ($select as $row)
        {
            $data[]=$row;
        }
        $select->closeCursor();
        $output = $this->addCategoryTree($data);
        return $output;
    }
    
    public function getPromo($limit = 5)
    {
        $query="SELECT pd.product_id as product_id, pd.product_name as product_name, pd.price as product_price, pm.price as new_price, (pd.price-pm.price) as discount, category, thumbnail, product_link FROM products pd LEFT JOIN promo pm ON pd.product_id = pm.product_id WHERE pm.price IS NOT NULL LIMIT $limit";
        $select=$this->pdo->query($query);
        foreach ($select as $row)
        {
            $data[]=$row;
        }
        $select->closeCursor();

        return $data;
    }
    
    public function getCategoryTree($categoryId)
    {
        $output = [];
        while (!is_null($categoryId))
        {
            $query="SELECT category_id, category_name, parent FROM categories WHERE category_id = '$categoryId'";
            $select=$this->pdo->query($query);
            $result = $select->fetch();
            array_unshift($output, $result['category_name']);
            $categoryId = $result['parent'];
        }
        return $output;
    }
    
    public function addCategoryTree($products)
    {
        $output = [];
        foreach ($products as $product)
        {
            $actualProduct = [];
            foreach ($product as $productAttribute => $productValue)
            {
                $actualProduct[$productAttribute] = $productValue;
            }
            $actualProduct['category_tree'] = $this->getCategoryTree($product['category']);
            $output[] = $actualProduct;
        }
        return $output;
    }
    
    public function getProductName($productId)
    {
        $query="SELECT product_name FROM products WHERE product_id = '$productId'";
        $select = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        return $select['product_name'];

    }
    
    public function getProductPrice($productId)
    {
        $query = "SELECT pd.price as product_price, pm.price as new_price FROM products pd LEFT JOIN promo pm ON pd.product_id = pm.product_id WHERE pd.product_id='$productId' LIMIT 1";
        $select = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        if (isset($select['new_price']))
        {
            return $select['new_price'];
        }
        else
        {
            return $select['product_price'];
        }
    }
    
    public function getProductThumbnail($productId)
    {
        $query="SELECT product_link, thumbnail FROM products WHERE product_id = '$productId'";
        $select = $this->pdo->query($query, PDO::FETCH_ASSOC)->fetch();
        $path = self::IMAGE_PATH.$productId."/".$select['product_link']."-".$select['thumbnail'].".jpg";
        return $path;
    }
    
    public function getSummaryForCart($cartItems)
    {
        $totalPrice = 0;
        $output = [];
        foreach ($cartItems as $productId=>$amount)
        {
            $productName = $this->getProductName($productId);
            $productPrice = $this->getProductPrice($productId);
            $productThumbnail = $this->getProductThumbnail($productId);
            $productPriceTotal = $productPrice * $amount;
            $output[$productId] = [
                'thumbnail'=>$productThumbnail,
                'name'=>$productName,
                'price'=>$productPrice,
                'amount'=>$amount,
                'priceTotal'=>$productPriceTotal
                ];
        }
        return $output;
    }
    
    public function getSummaryForCartShort($cartItems)
    {
        $totalPrice = 0;
        $output = [];
        foreach ($cartItems as $productId=>$amount)
        {
            $productPrice = $this->getProductPrice($productId);
            $productPriceTotal = $productPrice * $amount;
            $output['products'][$productId] = [
                'amount'=>$amount,
                'price'=>$productPrice
                ];
            $totalPrice += $productPriceTotal;
        }
        $output['totalPrice'] = $totalPrice;
        return $output;
    }
}
?>
