<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::MATCH);

$count = 0;
foreach($files as $file) {
    if ($file->isDir()) continue;
    
    $path = $file->getPathname();
    $content = file_get_contents($path);
    
    $hasChanges = false;
    
    // Replace #FF8C42 with var(--ud-orange)
    if (strpos($content, '#FF8C42') !== false) {
        $content = str_replace('#FF8C42', 'var(--ud-orange)', $content);
        $hasChanges = true;
    }
    
    // Replace #FFB800 with var(--ud-accent)
    if (strpos($content, '#FFB800') !== false) {
        $content = str_replace('#FFB800', 'var(--ud-accent)', $content);
        $hasChanges = true;
    }

    // Replace gradient if present: linear-gradient(135deg, #FF8C42, #ea580c)
    // Actually, we can just replace #ea580c with var(--ud-orange-dark)
    if (strpos($content, '#ea580c') !== false) {
        $content = str_replace('#ea580c', 'var(--ud-orange-dark)', $content);
        $hasChanges = true;
    }

    if ($hasChanges) {
        file_put_contents($path, $content);
        echo "Updated: $path\n";
        $count++;
    }
}

echo "Done. Updated $count files.\n";
