<?php $lines = file("authenticated_dump.html"); foreach ($lines as $idx => $line) { if ($idx >= 1360 && $idx <= 1380) { echo ($idx + 1) . ": " . rtrim($line) . "\n"; } }
