<?php
    require_once './helpers/MemberDao.php';

    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['member'])) {
        $member = $_SESSION['member'];
    }



?>
<header>
    <link rel="stylesheet" href="./css/HeaderStyle.css">
    <div id="logo">
        <a href="index.php">
            <img src="./images/JecShoppingLogo.jpg" alt="JEC Shoppingロゴ" />
        </a>
    </div>
    <div id="link">
        <?php if(isset($member)):?>
            <?= $member->membername ?>さん
            <a href="cart.php">カート</a>
            <a href="logout.php">ログアウト</a>
        <?php else: ?>
               
        <a href="login.php" >ログイン</a>
        <?php endif; ?>
    </div>
    <div id="clear">
        <hr>
    </div>
    
</header>