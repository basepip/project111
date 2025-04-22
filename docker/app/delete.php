<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $post_id = $_POST["id"];

    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $post_id);

    if ($stmt->execute()) {
        echo "게시물이 삭제되었습니다.";
    } else {
        echo "삭제에 실패했습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시물 삭제</title>
</head>
<body>
    <h1>게시물 삭제</h1>
    <form method="POST">
        <label for="id">삭제할 게시물 ID:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">삭제</button>
    </form>
</body>
</html>
