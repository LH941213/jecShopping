<?php
    require_once 'helpers/MemberDao.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['confirm_password'] ?? '';
        $membername = $_POST['name'] ?? '';
        $zipcode = $_POST['postal_code'] ?? '';
        $address = $_POST['address'] ?? '';
        $tel1 = $_POST['tel1'] ?? '';
        $tel2 = $_POST['tel2'] ?? '';
        $tel3 = $_POST['tel3'] ?? '';
        $memberDAO = new MemberDao();
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errs['email'] = 'メールアドレスの形式が正しくありません。';
        }
        else if ($memberDAO->email_exists($email)) {
            $errs['email'] = 'このメールアドレスはすでに登録されています。';
        }
        if(!preg_match('/\A.{4,}\z/', $password)) {
            $errs['password'] = 'パスワードは4文字以上で入力してください。';
        }
        else if ($password !== $password2) {
            $errs['password'] = 'パスワードが一致しません。';
        }
        if ($membername === '') {
            $errs['membername'] = 'お名前を入力してください。';
        }
        if(!preg_match('/\A([0-9]{3})-([0-9]{4})\z/', $zipcode)) {
            $errs['zipcode'] = '郵便番号は3桁-4桁で入力してください。';
            
        }
        if ($address === '') {
            $errs['address'] = '住所を入力してください。';
        }
        if(!preg_match('/\A(\d{2,5})?\z/', $tel1) || 
           !preg_match('/\A(\d{1,4})?\z/', $tel2) || 
           !preg_match('/\A(\d{4})?\z/', $tel3)) {
            $errs['tel'] = '電話番号は半角数字2-5桁-1-4桁-4桁で入力してください。';
        }
        if(empty($errs)) {
           $member = new Member();
        $member->email = $email;
        $member->password = $password;
        $member->membername = $membername;
        $member->zipcode = $zipcode;
        $member->address = $address;
        $member->tel='';
        if($tel1 !== '' && $tel2 !== '' && $tel3 !== '') {
            $member->tel = "{$tel1}-{$tel2}-{$tel3}";
        }
        $memberDAO->insert($member);
        header('Location: signupEnd.php');
        exit;
        }
        
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>新規会員登録</title>
</head>
<body>
    <?php include 'header2.php'; ?>
    <h1>会員登録</h1>
    <p>以下の項目を入力し、登録ボタンをクリックしてください。(*は必須)</p>
    <form action="" method="post">
        <table>
             <tr>
                <td>メールアドレス*</td>
                <td><input type="text" name="email" value="<?=@$email ?>">
                <span style="color: red;"><?= @$errs['email']?></span>
            </td>
            </tr>
            <tr>
                <td>パスワード4文字以上*</td>
                <td><input type="password" name="password" value="<?=@$password?>">
                <span style="color: red;"><?= @$errs['password']?></span>
            </td>
            </tr>
             <tr>
                <td>パスワード(再入力)*</td>
                <td><input type="password" name="confirm_password" ></td>
            </tr>
            <tr>
                <td>お名前*</td>
                <td><input type="text" name="name" value="<?=@$membername?>">
                <span style="color: red;"><?= @$errs['membername']?></span>
            </td>
            </tr>
           <tr>
                <td>郵便番号*</td>
                <td>
                    <input type="text" name="postal_code" value="<?=@$zipcode ?>">
                    <span style="color: red;"><?= @$errs['zipcode']?></span>
            </td>
            </tr>
            <tr>
                <td>住所*</td>
                <td><input type="text" name="address" value="<?=@$address ?>">
                <span style="color: red;"><?= @$errs['address']?></span>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <input type="tel" name="tel1" size="4" value="<?=@$tel1?>"> -
                    <input type="tel" name="tel2" size="4" value="<?=@$tel2?>"> -  
                    <input type="tel" name="tel3" size="4" value="<?=@$tel3?>">
                    <span style="color: red;"><?= @$errs['tel']?></span>
                </td>
            </tr>
            
            
           
            
        </table>
        <input type="submit" value="登録する">
    </form>
</body>
</html>