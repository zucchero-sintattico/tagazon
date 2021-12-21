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


?>