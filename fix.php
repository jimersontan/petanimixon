<?php

$dir = __DIR__ . '/resources/views';

function scanAllDir($dir) {
    if(!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($path)) {
            scanAllDir($path);
        } else {
            if (substr($path, -10) === '.blade.php') {
                processFile($path);
            }
        }
    }
}

function processFile($filePath) {
    if (!is_writable($filePath)) return;
    
    $content = file_get_contents($filePath);
    $newContent = str_replace(['Animixon', 'animixon'], ['Markt-PH', 'markt-ph'], $content);
    
    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
    }
}

scanAllDir($dir);
echo "Fix complete.\n";
