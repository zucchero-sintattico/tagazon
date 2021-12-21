<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Libraries -->
    <script src="../lib/jquery-3.6.0.min.js" defer></script>

    <!-- User-Defined Libraries -->
    <script src="./js/start.js"></script>
    <script src="./js/user-manager.js" defer></script>
    <script src="./js/notifications-service.js" defer></script>

    <!-- PHP-based -->
    <title>Tagazon - <?php echo ucfirst($page); ?></title>
    <script src="./pages/<?php echo $page;?>/<?php echo $page;?>.js" defer></script>
    <link rel="stylesheet" href="./pages/<?php echo $page;?>/<?php echo $page;?>.css"/>

</head>
<body>
    
    <!-- HTML Page -->
    <?php require __DIR__ . "/$page/$page.html"; ?>

</body>
</html>