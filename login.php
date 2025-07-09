<?php
    
    require_once "./helpers/MemberDao.php";
    $email= "";
    $errs= [];
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $memberDao = new MemberDao();
        $member=$memberDao->get_member($email, $password);
        if ($member !== false) {
            session_regenerate_id(true);
            $_SESSION['member'] = $member;
            header('Location: index.php');
            exit;
        }else {
            $errs[] = "メールアドレスまたはパスワードに誤りがあります。";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <!--header2.phpの内容をここに挿入-->
    <?php include "header2.php"; ?>
    <form action="login.php" method="post">
        <table>
           <tr>
            <th colspan="2">ログイン</th>
           </tr>
        <tr>
            <td>メールアドレス</td>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td><input type="password" name="password"></td>
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
</body>
</html>