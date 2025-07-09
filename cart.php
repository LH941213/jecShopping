<?php
require_once "helpers/CartDAO.php";
require_once "helpers/MemberDAO.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if (empty($_SESSION['member'])) {
       
        header('Location: login.php');
        exit;
    }
    $member=$_SESSION['member'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if (isset($_POST['add'])) {
            $goodscode = $_POST['goodscode'];
            $num = $_POST['num']; // デフォルト値を1に設定
            $cartDao = new CartDAO();
            
            // カートに商品を追加
            $cartDao->insert($member->memberid, $goodscode, $num);
    
        }
        else if (isset($_POST['change'])) {
            $goodscode = $_POST['goodscode'];
            $num = $_POST['num'];
            $cartDao = new CartDAO();
            
            // カート内の商品数量を更新
            $cartDao->update($member->memberid, $goodscode, $num);
        }
        else if (isset($_POST['delete'])) {
            $goodscode = $_POST['goodscode'];
            $cartDao = new CartDAO();
            
            // カートから商品を削除
            $cartDao->delete($member->memberid, $goodscode);
        }
}
    $cartDao = new CartDAO();
    $cart_list = $cartDao->get_cart_by_memberid($member->memberid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>ショッピングカート</title>
</head>
<body>
    <?php include "header.php"; ?>
    <?php if(empty($cart_list)): ?>
        <p>カートに商品がありません。</p>
    <?php else: ?>
        <?php foreach ($cart_list as $cart): ?>
            <table>
                <tr>
                    <td rowspan="4">
                        <a href="goods.php?goodscode=<?= $cart->goodscode ?>">
                        <img src="images/goods/<?= $cart->goodsimage ?>" >
                        </a>
                    </td>
                    <td>
                        <a href="goods.php?goodscode=<?= $cart->goodscode ?>">
                        <?= $cart->goodsname ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $cart->detail ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        ￥<?= number_format($cart->price) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form action="" method="post">
                             数量
                            <input type="text" name="num" value="<?= $cart->num ?>">
                            <input type="hidden" name="goodscode" value="<?= $cart->goodscode ?>">
                            <input type="submit" name="change" value="変更">
                            <input type="submit" name="delete" value="削除">
                        </form>
                       
                    </td>
                </tr>
            </table>
            <hr>
        <?php endforeach; ?>
        <form action="buy.php" method="post">
            <input type="hidden" name="memberid" value="<?= $member->memberid ?>">
            <input type="submit" value="商品を購入する">
        </form>
        <?php endif; ?>
</body>
</html>