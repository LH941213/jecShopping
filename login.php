<?php
    
    require_once "./helpers/MemberDao.php";
    $email= "";
    $errs= [];
    // セッションが開始されていない場合は開始
    session_start();

    if (!isset($_SESSION['member'])) {
        header('Location: index.php');
        exit;
    }
    // POSTリクエストが送信された場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // フォームからメールアドレスとパスワードを取得
        $email = $_POST['email'];
        $password = $_POST['password'];

        if($email==='') {
            $errs[] = "メールアドレスを入力してください。";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errs[] = "メールアドレスの形式に誤りがあります。";
        }
        if($password==='') {
            $errs[] = "パスワードを入力してください。";
        }
        if (empty($errs)) {

        $memberDao = new MemberDao();
        $member=$memberDao->get_member($email, $password);
        // メンバー情報が取得できた場合
        if ($member !== false) {
            // セッションIDを再生成してセキュリティを強化
            session_regenerate_id(true);
            // セッションにメンバー情報を保存
            $_SESSION['member'] = $member;
            header('Location: index.php');
            exit;
        }else {
            $errs[] = "メールアドレスまたはパスワードに誤りがあります。";
        }
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/LoginStyle.css">
    <title>ログイン</title>
</head>
<body>
    <!--header2.phpの内容をここに挿入-->
    <?php include "header2.php"; ?>
    <form action="login.php" method="post">
        <table id="LoginTable" class="box">
           <tr>
            <th colspan="2">ログイン</th>
           </tr>
        <tr>
            <td>メールアドレス</td>
            <td><input type="email" name="email" required autofocus></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="login">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                
                <?php foreach ($errs as $err): ?>
                    <span style="color: red;"><?= $err ?></span>
                    <br>
                <?php endforeach; ?>
                    
            </td>
        </tr>
        </table>
    </form>
    <table class="box">
        <tr>
            <th>初めてご利用の方</th>
        </tr>
        <tr>
            <td>
                ログインするには、会員登録が必要です。
            </td>
        </tr>
        <tr>
            <td>
                <a href="signup.php">新規会員登録はこちら</a>
            </td>
        </tr>
    </table>
</body>
</html>