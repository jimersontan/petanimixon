<?php
$file = 'resources/views/inventory_admin.blade.php';
$content = file_get_contents($file);

// Replace 1
$find = "const wetOrDryGroup = document.getElementById('wetOrDryGroup');";
$replace = preg_replace('/\r/', '', "const wetOrDryGroup = document.getElementById('wetOrDryGroup');\n        const weightKgGroup = document.getElementById('weightKgGroup');");
$content = str_replace($find, $replace, $content);

// Replace 2
$find2 = "wetOrDryGroup.style.display = 'block';";
$replace2 = preg_replace('/\r/', '', "if(wetOrDryGroup) wetOrDryGroup.style.display = 'block';\n                if(weightKgGroup) weightKgGroup.style.display = 'block';");
$content = str_replace($find2, $replace2, $content);

// Replace 3
$find3 = "wetOrDryGroup.style.display = 'none';";
$replace3 = preg_replace('/\r/', '', "if(wetOrDryGroup) wetOrDryGroup.style.display = 'none';\n                if(weightKgGroup) weightKgGroup.style.display = 'none';\n                const weightKgInput = document.getElementById('weight_in_kg');\n                if(weightKgInput) weightKgInput.value = '';");
$content = str_replace($find3, $replace3, $content);

// Replace 4
$find4 = "'wet_or_dry': data.wet_or_dry";
$replace4 = preg_replace('/\r/', '', "'wet_or_dry': data.wet_or_dry,\n                'weight_in_kg': data.weight_in_grams ? (data.weight_in_grams / 1000) : ''");
$content = str_replace($find4, $replace4, $content);

// Replace 5
$find5 = "if (!categorySelect || !wetOrDryGroup) return;";
$replace5 = "if (!categorySelect) return;";
$content = str_replace($find5, $replace5, $content);

file_put_contents($file, $content);
echo "DONE";
