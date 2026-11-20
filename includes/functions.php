<?php
function readJSON($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    $jsonData = file_get_contents($filePath);
    return json_decode($jsonData, true);
}

function writeJSON($filePath, $data) {
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function excerpt($text, $length = 130) {
    $text = trim(preg_replace('/\s+/u', ' ', (string) $text));
    if (!function_exists('mb_strlen')) {
        return strlen($text) > $length ? substr($text, 0, $length) . '…' : $text;
    }
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length, 'UTF-8') . '…';
}

function paragraphs($text) {
    $lines = preg_split('/\R/u', trim((string) $text));
    return array_values(array_filter(array_map('trim', $lines), 'strlen'));
}

function isYes($value) {
    return strcasecmp(trim((string) $value), 'Yes') === 0;
}

// JSON ထဲတွင် "../img/1.jpg" ကဲ့သို့ သိမ်းထားသော လမ်းကြောင်းများကို စာမျက်နှာနှင့် ကိုက်ညီအောင် ပြန်ညှိသည်။
function imageUrl($path) {
    $path = trim((string) $path);
    if ($path === '') {
        return '';
    }
    $normalized = preg_replace('#^(\.\./)+#', '', str_replace('\\', '/', $path));
    if (is_file(__DIR__ . '/../' . $normalized)) {
        return $normalized;
    }
    return $path;
}
