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
    <div>
        <a href="index.php">
            <img src="./images/JecShoppingLogo.jpg" alt="JEC Shoppingロゴ" />
        </a>
    </div>
    <div>
        <?php if(isset($member)):?>
            <?= $member->membername ?>さん
            <a href="cart.php">カート</a>
            <a href="logout.php">ログアウト</a>
        <?php else: ?>
               
        <a href="login.php" >ログイン</a>
        <?php endif; ?>
    </div>
    <hr>
</header>