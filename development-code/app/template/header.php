<!doctype html>
<html>
    <head>
        <base href="<?=SITE_DIR;?>">
        <meta charset="utf-8">
        <title><?=$title;?></title>
        //<link href="<?=SITE_DIR?>template/css/style.css" rel="stylesheet">
        //<link href="<?=SITE_DIR?>icon.png" type="image/x-icon" rel="shortcut icon">
        <link href="template/css/style.css" rel="stylesheet">
        <link href="icon.png" type="image/x-icon" rel="shortcut icon">
    </head>
    <body>
        <header>
            <div class="title">Web-программирование</div>
            <?php require_once("menu.php");?>
        </header>
        <main>
           <?php require_once("aside.php");?>
            <section>
