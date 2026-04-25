<?php
$lines = file('storage/logs/laravel.log');
$matches = [];
foreach ($lines as $line) {
    if (strpos($line, 'Remove.bg') !== false) {
        $matches[] = $line;
    }
}
$recent = array_slice($matches, -20);
echo implode("", $recent);
