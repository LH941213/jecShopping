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
}
?>