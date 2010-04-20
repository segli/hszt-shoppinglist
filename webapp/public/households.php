<?php

include_once('../config/environment.php');
include_once('../controllers/session.controller.php');

?>
<?php
include_once('includes/html_head.php');?>
    <body>
        <h1 class="base"><a href="/">Shopping List</a> - Households</h1>

        <?php
        include_once('modules/mod.households.php');
        ?>

    <?php include_once('includes/html_javascripts.php');?>        
    </body>
</html>