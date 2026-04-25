<?php

$dir = "c:/Users/John Carry/.gemini/antigravity/scratch/Pet Markt-PH/resources/views"; // Pet Markt-PH

$layoutAside = "";

// 1. Get the correct <aside> from layouts/admin.blade.php
$adminLayoutFile = $dir . "/layouts/admin.blade.php";
$adminLayoutContent = file_get_contents($adminLayoutFile);

if (preg_match('/<aside class="sidebar"[^>]*>.*?<\/aside>/s', $adminLayoutContent, $matches)) {
    $layoutAside = $matches[0];
} else {
    die("Could not find <aside> in layouts/admin.blade.php");
}

// 2. Put it into partials/admin_sidebar.blade.php
file_put_contents($dir . "/partials/admin_sidebar.blade.php", $layoutAside);

// 3. Now loop all files in resources/views and replace <aside...>...</aside> with @include('partials.admin_sidebar')
function processDir($dir) {
    $files = glob($dir . "/*");
    foreach($files as $file) {
        if (is_dir($file)) {
            processDir($file);
        } else if (pathinfo($file, PATHINFO_EXTENSION) == "php") {
            // Skip the partial itself
            if (basename($file) == "admin_sidebar.blade.php") continue;
            
            $content = file_get_contents($file);
            $newContent = preg_replace('/<aside class="sidebar"[^>]*>.*?<\/aside>/s', "@include('partials.admin_sidebar')", $content);
            if ($newContent !== null && $newContent !== $content) {
                file_put_contents($file, $newContent);
                echo "Updated: $file\n";
            }
        }
    }
}

processDir($dir);

echo "Done!\n";
