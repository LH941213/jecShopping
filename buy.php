<?php
    require_once "helpers/MemberDAO.php";
    require_once "helpers/SaleDao.php";

    session_start();
    if($_SESSION['member'] === null) {
        header('Location: login.php');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: cart.php');
        exit;
    }
    $member = $_SESSION['member'];

    $cartDAO = new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->memberid);

    $saleDAO = new SaleDao();
    $saleDAO->insert($member->memberid, $cart_list);

    // 購入後にカートを空にする
    $cartDAO->delete_by_memberid($member->memberid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入完了</title>
</head>
<body>
    <?php include "header.php"; ?>
    <p>購入が完了しました</p>
    
    <p><a href="index.php">トップページへ</a></p>
</body>
</html>