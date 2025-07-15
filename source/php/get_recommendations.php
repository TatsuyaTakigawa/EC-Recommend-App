<?php
    // session開始
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // ログインしてなければログイン画面へ
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Flask APIのエンドポイント
    $api_ep = 'http://127.0.0.1:8000/predict';

    // JSON形式のペイロード
    $payload = json_encode(['user_id' => $user_id]);

    // cURLでPOSTリクエスト送信
    $ch = curl_init($api_ep);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);

    curl_close($ch); // return の前に移動

    if (curl_errno($ch)) {
        echo "cURLエラー: " . curl_error($ch);
        return [];  // エラー時も配列を返すと安全
    } else {
        $result = json_decode($response, true);
        return $result['recommendations'] ?? $result['predictions'] ?? [];
}
?>
