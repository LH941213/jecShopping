<?php
    require_once "helpers/GoodsDAO.php";
    if (isset($_GET['goodscode'])) {
        $goodscode = $_GET['goodscode'];
        $goodsDAO = new GoodsDAO();
        $goods= $goodsDAO->get_goods_by_goodscode($goodscode);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
</head>
<body>
    <?php include "header.php"; ?>
    <table>
        <tr>
            <td rowspan="5">
                <img src="./images/goods/<?= $goods->goodsimage ?>" alt="<?= $goods->goodsname ?>">
            </td>
            <td>
                <p><?= $goods->goodsname ?></p>
            </td>

            
        </tr>
        <tr>
            <td>
                <p><?= $goods->detail ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>価格: ￥<?= number_format($goods->price) ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <?= $goods->recommend ? "おすすめ商品" : "　" ?>
            </td>
        </tr>
        <tr>
            <td>
                <form action="cart.php" method="post">
                    個数: 
                    <select name="num">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    <input type="hidden" name="goodscode" value="<?= $goods->goodscode ?>">
                    <input type="submit" name="add" value="カートに入れる">
                    
                </form>
            </td>
        </tr>
    </table>
</body>
</html>