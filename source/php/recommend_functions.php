<?php
require_once __DIR__ . '/DBManager.php';

/**
 * [内部関数] APIサーバーにリクエストを送信し、おすすめ商品IDを取得します。
 */
function fetchRecommendationIds($userId)
{
    $apiEndpoint = 'http://127.0.0.1:8000/predict';
    $payload = json_encode(['user_id' => $userId]);
    $ch = curl_init($apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    if (curl_errno($ch)) { error_log('cURL Error: ' . curl_error($ch)); curl_close($ch); return []; }
    curl_close($ch);
    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) { error_log('JSON Decode Error: ' . json_last_error_msg()); return []; }
    $allIds = $result['recommendations'] ?? $result['predictions'] ?? [];
    return is_array($allIds) ? $allIds : [];
}

/**
 * 【公開関数】おすすめ商品のデータ配列を取得します。
 *
 * @param string|int $userId ユーザーID。
 * @param int $limit 取得する最大件数 (デフォルトは4件)。
 * @return array 商品情報の連想配列の配列。失敗時は空配列 []。
 */
function getRecommendedProducts($userId, $limit = 4)
{
    $recommendedIds = fetchRecommendationIds($userId);
    if (empty($recommendedIds)) {
        return [];
    }
    $targetIds = array_slice($recommendedIds, 0, $limit);
    try {
        $pdo = getDB();
        $placeholders = implode(',', array_fill(0, count($targetIds), '?'));
        $sql = "SELECT * FROM ec_item WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($targetIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}