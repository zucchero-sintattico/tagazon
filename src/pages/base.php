<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Libraries -->
    <script src="./res/lib/jquery-3.6.0.min.js"></script>
    <script src="./res/lib/mqtt.min.js"></script>

    <!-- 
        PHP-based

        <?php 
            /** 
             * @var string $page 
             * */ 
        ?> 
    -->
    <title>Tagazon - <?php echo ucfirst($page); ?></title>
    <link rel="stylesheet" href="./pages/<?php echo $page;?>/<?php echo $page;?>.css"/>
    <script type="module" src="./pages/<?php echo $page;?>/<?php echo $page;?>.js"></script>
    <script type="module">
        <?php $pageClass = str_replace('_', '', ucwords($page, '_')) . "Page" ?>
        import {Application} from './res/js/application.js';
        import {<?php echo $pageClass; ?>} from './pages/<?php echo $page;?>/<?php echo $page;?>.js';
        
        Application.start(new <?php echo $pageClass; ?>());
    </script>

</head>
<body>
    
    
    <!-- HTML Page -->
    <?php require __DIR__ . "/$page/$page.html"; ?>

</body>
</html>