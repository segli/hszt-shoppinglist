<?php
include_once('../config/environment.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>
      Shopping List
    </title>
    <meta content="IE=8" http-equiv="x-ua-compatible" />
    <meta content="Shopping List" name="description" />
    <meta content="text/html;charset=utf-8" http-equiv="content-type" />
    <meta content="text/css" http-equiv="content-style-type" />
    <meta content="text/javascript" http-equiv="content-script-type" />
    <link href="stylesheets/yui-reset-min.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="stylesheets/yui-fonts-min.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="stylesheets/oocss-grids.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="stylesheets/oocss-mod.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="stylesheets/shoppinglist.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="stylesheets/shoppinglist.login.css" media="all" rel="stylesheet" type="text/css"/>
    <!--[if lte IE 7]>
      <link href="stylesheets/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if lte IE 6]>
      <link href="stylesheets/ie6.css" rel="stylesheet" type="text/css" />
    <![endif]-->

  </head>
    <body>
        <h1 class="base">Shopping List</h1>

        <?php
        include_once('modules/mod.login.php');

        ?>

        <script type="text/javascript" src="javascripts/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="javascripts/shoppinglist.js"></script>
        <script type="text/javascript" src="javascripts/shoppinglist.mod.login.js"></script>
    </body>
</html>