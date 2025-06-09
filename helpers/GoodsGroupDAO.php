<?php
    require_once "DAO.php";
    class GoodsGroup{
        public int $groupcode;
        public string $groupname;
    }
    class GoodsGroupDAO {
        public static function get_goodsgroup() {
           $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM goodsgroup";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data=[];    
            while ($row = $stmt->fetchObject('GoodsGroup')) {
                
                $data[] = $row;
            }
            return $data;
        }
    }