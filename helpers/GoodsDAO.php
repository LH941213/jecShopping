<?php
require_once "DAO.php";
class Goods{
    public string $goodscode;
    public string $goodsname;
    public int $price;
    public string $detail;
    public int $groupcode;
    public bool $recommend;
    public string $goodsimage;
}
class GoodsDao{
    public function get_recommend_goods(){
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM goods WHERE recommend = 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data= [];
        while($row=$stmt->fetchobject("Goods")){
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_groupcode(int $groupcode){
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM goods WHERE groupcode = :groupcode order by recommend DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':groupcode', $groupcode, PDO::PARAM_INT);
        $stmt->execute();
        $data= [];
        while($row=$stmt->fetchobject("Goods")){
            $data[] = $row;
        }
        return $data;

    }
    public function get_goods_by_goodscode(string $goodscode){
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM goods WHERE goodscode = :goodscode";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':goodscode', $goodscode, PDO::PARAM_STR);
        $stmt->execute();
        $goods= $stmt->fetchObject("Goods");
        return $goods;
    }
}
?>