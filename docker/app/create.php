<?php
// create.php
require_once 'config.php';

// 로그인되어 있지 않으면 접근 제한
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $filename = null;

    // 파일 업로드 처리
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        // 업로드할 파일 관련 검증(크기, MIME 타입 등)을 수행
        $uploadDir = __DIR__ . '/uploads/';
        $filename = basename($_FILES['file']['name']);
        $targetFile = $uploadDir . $filename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $error = "파일 업로드에 실패했습니다.";
        }
    }

    if (empty($title) || empty($content)) {
        $error = "제목과 내용을 모두 입력하세요.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, file, user_id) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $content, $filename, $_SESSION['user_id']])) {
            header("Location: index.php");
            exit;
        } else {
            $error = "게시글 작성 중 오류 발생";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>게시글 작성</title>
</head>
<body>
  <h1>게시글 작성</h1>
  <?php if(isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post" action="create.php" enctype="multipart/form-data">
    <label>제목: <input type="text" name="title"></label><br>
    <label>내용: <textarea name="content" rows="5" cols="40"></textarea></label><br>
    <label>파일 업로드: <input type="file" name="file"></label><br>
    <button type="submit">작성</button>
  </form>
  <p><a href="index.php">메인 페이지로</a></p>
</body>
</html>

