<?php
require 'config.php';

$search = "";
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["q"])) {
    $search = "%" . $_GET["q"] . "%";
    
    $sql = "SELECT * FROM posts WHERE title LIKE ? OR content LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $search);
    $stmt->bindParam(2, $search);
    $stmt->execute();
    
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시물 검색</title>
</head>
<body>
    <h1>게시물 검색</h1>
    <form method="GET">
        <label for="q">검색어:</label>
        <input type="text" id="q" name="q">
        <button type="submit">검색</button>
    </form>

    <hr>

    <h2>검색 결과:</h2>
    <ul>
        <?php foreach ($results as $post): ?>
            <li><strong><?= htmlspecialchars($post["title"]) ?></strong> - <?= htmlspecialchars($post["content"]) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>