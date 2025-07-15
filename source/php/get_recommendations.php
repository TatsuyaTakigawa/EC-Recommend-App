<?php
/**
 * APIサーバーにリクエストを送信し、ユーザーへのおすすめ商品IDを取得します。
 *
 * @param string|int $userId 対象となるユーザーのID。
 * @return array おすすめ商品IDの先頭4つの配列。API接続の失敗や、
 *               おすすめが見つからなかった場合は空の配列 [] を返します。
 */
function fetchRecommendationIds($userId)
{
    // Flask APIのエンドポイント
    $apiEndpoint = 'http://127.0.0.1:8000/predict';

    // 送信するデータをJSON形式にエンコード
    $payload = json_encode(['user_id' => $userId]);

    // cURLセッションを初期化
    $ch = curl_init($apiEndpoint);

    // cURLのオプションを設定
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 結果を文字列で受け取る
    curl_setopt($ch, CURLOPT_POST, true);           // POSTリクエストを指定
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // ヘッダー
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // 送信するデータ
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  // 接続タイムアウト（5秒）
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);         // 処理全体のタイムアウト（10秒）

    // リクエストを実行し、レスポンスを取得
    $response = curl_exec($ch);

    // cURL実行中にエラーが発生した場合
    if (curl_errno($ch)) {
        // エラーログに記録しておくと、後のデバッグに役立ちます
        error_log('cURL Error in fetchRecommendationIds(): ' . curl_error($ch));
        curl_close($ch);
        return []; // 空の配列を返して処理を終了
    }

    // cURLセッションを閉じる
    curl_close($ch);

    // 受け取ったJSONをPHPの連想配列に変換
    $result = json_decode($response, true);

    // JSONのデコードに失敗した場合
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON Decode Error in fetchRecommendationIds(): ' . json_last_error_msg());
        return []; // 空の配列を返す
    }

    // APIのレスポンスからIDのリストを取得 ('recommendations' or 'predictions')
    $allIds = $result['recommendations'] ?? $result['predictions'] ?? [];

    // 結果が配列でなかった場合も考慮
    if (!is_array($allIds)) {
        return [];
    }

    // 配列の先頭から4つの要素を切り出して返す
    return array_slice($allIds, 0, 4);
}