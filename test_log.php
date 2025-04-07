<?php

$ip = gethostbyname('api.telegram.org');
if ($ip === 'api.telegram.org') {
    die("Ошибка: DNS не разрешает адрес. Хостинг блокирует запросы к Telegram.");
} else {
    echo "IP Telegram API: " . $ip; // Если выведет IP — проблема не в DNS
}


// Лучше хранить токен и chat_id в отдельном файле (config.php)
define("TOKEN", "5061768214:AAHfbQdYrl8mkEnY17ac7SZq_73EgDSpfAs");
define("CHAT_ID", 312501439);
define("METHOD_NAME", "sendMessage");

// Отправка сообщения "YUP"
$send_data = [
    'chat_id' => CHAT_ID,
    'text' => "YUP"
];

$result = sendMessageTelegram(METHOD_NAME, $send_data);
print_r($result); // Вывод результата (для дебага)

function sendMessageTelegram($method, $data, $headers = []) {
    $url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
    $jsonData = json_encode($data);
    
    if ($jsonData === false) {
        return ["error" => "JSON encode failed: " . json_last_error_msg()];
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array_merge(["Content-Type: application/json"], $headers),
        CURLOPT_POSTFIELDS => $jsonData,
    ]);

    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        return ["error" => "cURL error: " . curl_error($curl)];
    }
    curl_close($curl);

    return json_decode($result, true) ?: $result;
}
?>
