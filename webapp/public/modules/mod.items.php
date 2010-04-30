<?php
include_once('../config/environment.php');
include_once('../controllers/session.controller.php');

?>

<div class="mod modItems">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Items in List &hellip;</h2>
        </div>
        <div class="bd bdExisting"></div>
        <div class="hd">
            <h2 class="base">Add Item</h2>
        </div>
        <div class="bd">
            <form class="create_item" action="controller_proxy.php?controller=createitem" method="post">
                <fieldset>
                    <div>
                        <label class="base">Item</label>
                        <input name="item_name" autocomplete="off" />
                    </div>
                    <input type="submit" value="add item" />
                </fieldset>
            </form>
        </div>
    </div>
</div>