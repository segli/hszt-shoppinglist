<?php
include_once('../config/environment.php');
include_once('../controllers/session.controller.php');
?>

<?php
include_once('includes/html_head.php');
?>

    <body>
        <h1 class="base"><a href="/households.php">Households</a> - Shoppinglists</h1>

        <?php include_once('modules/mod.shoppinglists.php'); ?>

    <?php include_once('includes/html_javascripts.php');?>        
    </body>
</html>