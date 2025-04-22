<?php
// login.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "잘못된 사용자명 혹은 비밀번호입니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>로그인</title>
</head>
<body>
  <h1>로그인</h1>
  <?php if(isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post" action="login.php">
    <label>사용자명: <input type="text" name="username"></label><br>
    <label>비밀번호: <input type="password" name="password"></label><br>
    <button type="submit">로그인</button>
  </form>
  <p><a href="register.php">회원가입 하러 가기</a></p>
</body>
</html>

