<?php
ini_set("display_errors",true);
require("global/php/framework.php");
require("global/php/mysql.php");
$global=new framework("global","global");
$global->title="[title]";
//$global->sql=new mysql("[ip]","[username]","[passwd]","[dbname]","utf8");
$global->sql=new mysql("localhost","root","868686","test","utf8");
$global->mongo=new Mongo("localhost:27017");
$global->mongodb=$global->mongo->selectDB("db");
$global->main();
?>
