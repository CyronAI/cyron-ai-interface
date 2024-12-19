<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Cho phép tất cả các nguồn

$apiKey = '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'; // Thay bằng API key thực tế
$url = 'https://api.openai.com/v1/completions';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['prompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'text-davinci-003',
    'prompt' => $data['prompt'],
    'max_tokens' => $data['max_tokens'] ?? 100,
]));

$result = curl_exec($ch);

if ($result === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to OpenAI']);
    exit;
}

curl_close($ch);
echo $result;
?>



