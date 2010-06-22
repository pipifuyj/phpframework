<?php
require("global/php/framework.php");
require("global/php/mysql.php");
$global=new framework("global","global");
$global->title="[title]";
$global->sql=new mysql("[ip]","[username]","[passwd]","[dbname]","utf8");
$global->main();
?>
