<?php
$dirs = [__DIR__ . '/database/seeders', __DIR__ . '/resources/views', __DIR__ . '/create_admin.php'];

$replacements = [
    'admin@petmarkt-ph.com' => 'admin@petmrkt.com',
    'admin@petmarkt-ph.com' => 'admin@petmrkt.com',
    'admin@petmarkt-ph.com'    => 'admin@petmrkt.com',
    
    'jimersontan@petmarkt-ph.com' => 'jimersontan@petmarkt.com',
    'jimersontan@petmarkt-ph.com' => 'jimersontan@petmarkt.com',
    'rider@petmarkt-ph.com'       => 'jimersontan@petmarkt.com',
    
    'user@petmarkt-ph.com'      => 'user@petmarkt.com',
    'user@petmarkt-ph.com'   => 'user@petmarkt.com',
    'user@petmarkt-ph.com'   => 'user@petmarkt.com'
];

function processPath($path, $replacements) {
    if (is_file($path)) {
        processFile($path, $replacements);
    } elseif (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            processPath($path . DIRECTORY_SEPARATOR . $file, $replacements);
        }
    }
}

function processFile($filePath, $replacements) {
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!in_array($ext, ['php']) && substr($filePath, -10) !== '.blade.php') return;
    
    if (!is_writable($filePath)) return;
    
    $content = file_get_contents($filePath);
    $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
    
    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
    }
}

foreach ($dirs as $dir) {
    processPath($dir, $replacements);
}
echo "Codebase emails updated successfully.\n";
