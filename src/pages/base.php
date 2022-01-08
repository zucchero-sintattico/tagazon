<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Libraries -->
    <script src="./res/lib/jquery-3.6.0.min.js"></script>
    <script src="./res/lib/mqtt.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/googlecode.min.css"/>
    <!-- Style for code -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>

    <!-- Style for code insert -->
    <script src="./res/lib/codemirror/lib/codemirror.js" defer></script>
    <script src="./res/lib/codemirror/mode/xml/xml.js" defer></script>
    <script src="./res/lib/codemirror/addon/edit/closetag.js" defer></script>
    <link rel="stylesheet" href="./res/lib/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="./res/lib/codemirror/theme/idea.css">

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
    <?php elseif ($page->isSeller()): ?>
        <link rel="stylesheet" href="./pages/navbar-seller/navbar-seller.css"/>
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
        } else if ($page->isSeller()) {
            require './pages/navbar-seller/navbar-seller.html';
        }
    ?>

</body>
</html>