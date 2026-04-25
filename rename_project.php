<?php

$dir = __DIR__;
$excludeDirs = ['storage', 'vendor', 'node_modules', '.git', '.idea'];
$extensions = ['php', 'blade.php', 'env', 'json', 'js', 'css', 'html', 'md'];

$replacements = [
    'Pet Markt-PH'  => 'Pet Markt-PH',
    'Pet Markt-PH'   => 'Pet Markt-PH',
    'PET MARKT-PH'  => 'PET MARKT-PH',
    'petmarkt-ph.com' => 'petmarkt-ph.com',
    'petmarkt-ph'   => 'petmarkt-ph'
];

function scanAllDir($dir, $excludeDirs, $extensions, $replacements) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($path)) {
            if (in_array($file, $excludeDirs)) continue;
            scanAllDir($path, $excludeDirs, $extensions, $replacements);
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (substr($path, -10) === '.blade.php') {
                $ext = 'blade.php';
            }
            if (in_array($ext, $extensions) || $file === '.env') {
                processFile($path, $replacements);
            }
        }
    }
}

function processFile($filePath, $replacements) {
    if (!is_writable($filePath)) return;
    
    $content = file_get_contents($filePath);
    $newContent = $content;
    
    foreach ($replacements as $search => $replace) {
        $newContent = str_replace($search, $replace, $newContent);
    }
    
    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
    }
}

scanAllDir($dir, $excludeDirs, $extensions, $replacements);
echo "Replacement complete.\n";
