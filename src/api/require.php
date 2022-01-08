<?php

function requireRecursive($dir, $depth=1) {
    $exclude=["require.php", "index.php", "mailer", ".", ".."];
    foreach (scandir($dir) as $filename) {
        if (in_array($filename, $exclude)) {
            continue;
        }
        $path = $dir . '/' . $filename;
        if (is_file($path)) {
            require_once $path;
        } else if (is_dir($path)) {
            requireRecursive($path, $depth + 1);
        }
    }
}

requireRecursive(__DIR__);
require_once __DIR__ . "/utils/mailer/PHPMailer.php";
require_once __DIR__ . "/utils/mailer/Exception.php";
require_once __DIR__ . "/utils/mailer/OAuth.php";
require_once __DIR__ . "/utils/mailer/Exception.php";
require_once __DIR__ . "/utils/mailer/POP3.php";
?>