<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $post_id = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $content);
    $stmt->bindParam(3, $post_id);

    if ($stmt->execute()) {
        echo "게시물이 수정되었습니다.";
    } else {
        echo "수정에 실패했습니다.";
    }
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시물 수정</title>
</head>
<body>
    <h1>게시물 수정</h1>
    <form method="POST">
        <label for="id">수정할 게시물 ID:</label>
        <input type="number" id="id" name="id" required>
        <br>
        <label for="title">새 제목:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="content">새 내용:</label>
        <textarea id="content" name="content" required></textarea>
        <br>
        <button type="submit">수정하기</button>
    </form>
</body>
</html>

