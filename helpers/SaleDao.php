<?php
    require_once "DAO.php";
    require_once "CartDAO.php";
    require_once "SaleDetailDAO.php";
    class SaleDao{
        public function get_saleno(){
            $dbh=DAO::get_db_connect();
            $sql="SELECT IDENT_CURRENT('sale') AS saleno";
            $stmt=$dbh->query($sql);
            $row=$stmt->fetchObject();
            
            return $row->saleno;

        }
        public function insert(int $memberid,Array $cart_list){
            $dbh=DAO::get_db_connect();
            $sql='insert into sale(saledate,memberid) values(:saledate,:memberid)';
            $stmt=$dbh->prepare($sql);
            $saledate = date('Y-m-d H:i:s');
            $stmt->bindValue(':saledate', $saledate, PDO::PARAM_STR);
            $stmt->bindValue(':memberid', $memberid, PDO::PARAM_INT);
            $stmt->execute();
            $saleno = $this->get_saleno();
            $saledetailDao = new SaleDetailDAO();
            foreach($cart_list as $cart){
                $saleDetail=new SaleDetail();
                $saleDetail->saleno = $saleno;
                $saleDetail->goodscode = $cart->goodscode;
                $saleDetail->num = $cart->num;
                $saledetailDao->insert($saleDetail,$dbh);
            }
        }
    }
?>