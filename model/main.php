<?php

include_once 'model/model.php';

class MainModel extends Model{

    public function getMainStart() {
        $query="SELECT start FROM contents";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row['start'];
        }
        $select->closeCursor();

        return $data;
    }
    public function getMainAbout() {
        $query="SELECT about FROM contents";
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data=$row['about'];
        }
        $select->closeCursor();

        return $data;
    }
}
?>
