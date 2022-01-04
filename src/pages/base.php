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
             * @var Page $page 
             * */ 
        ?> 
    -->
    <title>Tagazon - <?php echo $page->getFormatName(); ?></title>
    <link rel="stylesheet" href="<?php echo $page->getCss(); ?>"/>
    <?php if ($page->isNavbarPresent()): ?>
        <link rel="stylesheet" href="./pages/navbar/navbar.css"/>
    <?php endif; ?>
    <script type="module" src="<?php echo $page->getJs(); ?>"></script>
    <script type="module">
        <?php $pageController = $page->getFormatName() . "Page"; ?>
        import { Application } from './res/js/application.js';
        import {<?php echo $pageController; ?>} from '<?php echo $page->getJs(); ?>';
        
        Application.start(new <?php echo $pageController; ?>());
    </script>

</head>
<body>
    
    
    <!-- HTML Page -->
    <?php 
        require $page->getHtml(); 
        if ($page->isNavbarPresent()) {
            require './pages/navbar/navbar.html';
        }
    ?>

</body>
</html>