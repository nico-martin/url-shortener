<?php
function generateKey($length = 4) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return strtolower($key);
}

$url = $_POST['url'] ?? '';
if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo "Invalid URL.";
    exit;
}

$dataFile = 'urls.json';
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

do {
    $key = generateKey();
} while (isset($data[$key]));

$data[$key] = $url;
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
echo "<a href='/$key' target='_blank' class='text-blue-600 underline'>$scheme://$host/$key</a>";