<?php
    require_once 'DAO.php';
    class Member{
        public int $memberid;
        public string $email;
        public string $membername;
        public string $zipcode;
        public string $address;
        public string $tel;
        public string $password;
    }
    class MemberDao{
        //会員情報を取得するメソッド
        public function get_member(string $email,string $password){
            $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM member WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            
            $stmt->execute();
            $member = $stmt->fetchObject('Member');
            //会員データが取得できた場合、パスワードを確認
            if ($member !== false) {
                // パスワードのハッシュを確認
                // password_verifyは、ハッシュ化されたパスワードと入力されたパスワードを比較する関数
               if (password_verify($password, $member->password)) {
                    // パスワードが一致した場合、会員情報を返す
                     return $member;
                }
            }
                    return false;
        
           
        }
        public function insert(Member $member){
            $dbh= DAO::get_db_connect();
            $sql = "INSERT INTO member (email ,membername, zipcode, address, tel, password) 
                    VALUES (:email, :membername, :zipcode, :address, :tel, :password)";
            $stmt = $dbh->prepare($sql);
            $password= password_hash($member->password, PASSWORD_DEFAULT);
            $stmt->bindValue(':email', $member->email, PDO::PARAM_STR);
            $stmt->bindValue(':membername', $member->membername, PDO::PARAM_STR);
            $stmt->bindValue(':zipcode', $member->zipcode, PDO::PARAM_STR); 
            $stmt->bindValue(':address', $member->address, PDO::PARAM_STR);
            $stmt->bindValue(':tel', $member->tel, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

        }
        public function email_exists(string $email){
            $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM member WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->fetch() !== false) {
                return true;
            }
            else{
                return false;
            }
            
        }
    }
?>