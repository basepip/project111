<?php
// index.php
require_once 'config.php';

$stmt = $pdo->query("SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>메인 페이지 - 게시물 리스트</title>
</head>
<body>
  <h1>게시물 리스트</h1>
  <?php if(isset($_SESSION['username'])): ?>
    <p>환영합니다, <?= htmlspecialchars($_SESSION['username']) ?>님</p>
    <p><a href="logout.php">로그아웃</a></p>
  <?php else: ?>
    <p><a href="login.php">로그인</a> | <a href="register.php">회원가입</a></p>
  <?php endif; ?>

  <form action="search.php" method="GET">
    <input type="text" name="q" placeholder="검색어를 입력하세요">
    <button type="submit">검색</button>
  </form>
  <hr>

  <?php foreach ($posts as $post): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
      <h2><?= htmlspecialchars($post['title']) ?></h2>
      <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
      <?php if ($post['file']): ?>
        <p>첨부파일: <a href="uploads/<?= htmlspecialchars($post['file']) ?>" target="_blank"><?= htmlspecialchars($post['file']) ?></a></p>
      <?php endif; ?>
      <p>작성자: <?= htmlspecialchars($post['username'] ?? '익명') ?> | <?= $post['created_at'] ?></p>
      <!-- 수정/삭제 버튼은 작성자 본인(또는 관리자)만 볼 수 있도록 추가 검증 필요 -->
      <a href="update.php?id=<?= $post['id'] ?>">수정</a> |
      <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
    </div>
  <?php endforeach; ?>

  <p><a href="create.php">게시글 작성</a></p>
</body>
</html>

