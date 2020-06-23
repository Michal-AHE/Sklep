<?php

include_once 'model/model.php';

class MainModel extends Model{

    public function getMainStart() {
        $query="SELECT content FROM contents WHERE id='1'";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row['content'];
        }
        $select->closeCursor();

        return $data;
    }
    public function getMainAbout() {
        $query="SELECT content FROM contents WHERE id='2'";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row['content'];
        }
        $select->closeCursor();

        return $data;
    }
    
    public function getMainContact() {
        $query="SELECT content FROM contents WHERE id='3'";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row['content'];
        }
        $select->closeCursor();

        return $data;
    }
}
?>
