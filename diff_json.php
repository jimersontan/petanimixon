<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$p15=App\Models\Product::find(15)->toArray(); 
$p16=App\Models\Product::find(16)->toArray(); 
$diff = [];
foreach($p15 as $k=>$v) {
    if(!isset($p16[$k]) || $p16[$k] !== $v) {
        $val16 = isset($p16[$k]) ? $p16[$k] : 'NULL';
        $diff[$k] = ['ID15'=>$v, 'ID16'=>$val16];
    }
}
file_put_contents('diff.json', json_encode($diff, JSON_PRETTY_PRINT));
