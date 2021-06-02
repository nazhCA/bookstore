<head>
    <meta charset="UTF-8">
    <title>Bookstore</title>
    <link rel="stylesheet" type="text/css" href="./stylesheets/reset.css">
    <link rel="stylesheet" type="text/css" href="./stylesheets/style.css">
    <link rel="stylesheet" type="text/css" href="./stylesheets/admin_style.css">
</head>
<?php
include 'model/DbCon.php';
include 'view/Displayer.php';

$dbcon = new DbCon();
$displayer = new Displayer();
?>