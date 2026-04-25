<?php
$file = 'app/Http/Controllers/ProductAdminController.php';
$content = file_get_contents($file);

$find = "'wet_or_dry' => 'nullable|in:wet,dry',\n        ]);";
$replace = preg_replace('/\r/', '', "'wet_or_dry' => 'nullable|in:wet,dry',\n            'weight_in_kg' => 'nullable|numeric|min:0',\n        ]);\n        if (isset(\$data['weight_in_kg']) && \$data['weight_in_kg'] !== '') {\n            \$data['weight_in_grams'] = \$data['weight_in_kg'] * 1000;\n        } else {\n            \$data['weight_in_grams'] = null;\n        }");
$content = str_replace($find, $replace, $content);

file_put_contents($file, $content);
echo "DONE Controller";
