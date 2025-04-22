<?php
// register.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // 간단한 유효성 검사
    if (empty($username) || empty($password)) {
        $error = "모든 항목을 입력하세요.";
    } else {
        // 이미 존재하는 사용자 체크
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "이미 존재하는 사용자명입니다.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hash])) {
                header("Location: login.php");
                exit;
            } else {
                $error = "회원가입 중 오류 발생";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>회원가입</title>
</head>
<body>
  <h1>회원가입</h1>
  <?php if(isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post" action="register.php">
    <label>사용자명: <input type="text" name="username"></label><br>
    <label>비밀번호: <input type="password" name="password"></label><br>
    <button type="submit">회원가입</button>
  </form>
  <p><a href="login.php">로그인 하러 가기</a></p>
</body>
</html>

