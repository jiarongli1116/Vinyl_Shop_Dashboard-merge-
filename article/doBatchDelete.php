<?php
require_once "../components/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 獲取 POST 數據
        $data = json_decode(file_get_contents('php://input'), true);
        $ids = $data['ids'] ?? [];

        if (empty($ids)) {
            throw new Exception('未選擇任何文章');
        }

        // 開始事務
        $pdo->beginTransaction();

        // 更新選中的文章為已刪除狀態
        $sql = "UPDATE articles SET is_deleted = 1, deleted_at = NOW() WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);

        // 提交事務
        $pdo->commit();

        // 返回成功響應
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => '已成功將選中的文章移至回收站'
        ]);
        exit;

    } catch (Exception $e) {
        // 回滾事務
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // 返回錯誤響應
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
} else {
    // 返回錯誤響應
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => '無效的請求方法'
    ]);
    exit;
}
?>
