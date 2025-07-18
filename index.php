<?php
    
     require_once "helpers/GoodsGroupDAO.php";
     require_once "helpers/GoodsDAO.php";
     $goodsGroupDAO = new GoodsGroupDAO();
     $goodsgroup_list = $goodsGroupDAO->get_goodsgroup();
     $goodsDAO=new GoodsDAO();
    $goods_list = $goodsDAO->get_recommend_goods();
    $keyword = "";
    if (isset($_GET['groupcode'])) {
        $groupcode = $_GET['groupcode'];
        $goods_list = $goodsDAO->get_goods_by_groupcode($groupcode);
    }else if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
        $goods_list = $goodsDAO->get_goods_by_keyword($keyword);
    }else {
        $goods_list = $goodsDAO->get_recommend_goods();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>jecShopping</title>
    <link rel="stylesheet" href="css/IndexStyle.css">
</head>
<body>
    <?php include "header.php"; ?>
    検索結果:<?= $keyword?>
    <table id="goodsgroup">
        <?php foreach ($goodsgroup_list as $goodsgroup): ?>
            <tr>
                <td>
                    
                    <a href="index.php?groupcode=<?= $goodsgroup->groupcode ?>">
                     <?= $goodsgroup->groupname ?>
                    </a>
                </td>
               
            </tr>
        <?php endforeach; ?>
    </table>
    <div id="goodslist">
             <?php foreach ($goods_list as $goods): ?>
        <table align="left" style="margin-bottom: 30px">
            <tr>
                <td>
                    <a href="goods.php?goodscode=<?= $goods->goodscode ?>">
                    <img src="images/goods/<?= $goods->goodsimage ?>" >
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="goods.php?goodscode=<?= $goods->goodscode ?>">
                    <?= $goods->goodsname ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    ￥<?= number_format($goods->price) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $goods->recommend ?"おすすめ" : "　" ?>
                </td>
            </tr>
        </table>
    </div>
   
    <?php endforeach; ?>
</body>
</html>