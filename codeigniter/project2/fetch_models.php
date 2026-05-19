<?php
$envContent = file_get_contents(__DIR__ . '/.env');
preg_match('/GEMINI_API_KEY\s*=\s*"?([^\s"]+)/', $envContent, $matches);
$key = $matches[1] ?? '';
if (!$key) { die("Key not found"); }

$url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . $key;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);
if (isset($data['models'])) {
    foreach ($data['models'] as $m) {
        if (strpos($m['name'], 'gemini') !== false) {
            echo str_replace('models/', '', $m['name']) . "\n";
        }
    }
} else {
    print_r($data);
}
