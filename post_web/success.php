<?php
session_start(); // 세션 시작

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    // 로그인 상태가 아니라면 로그인 페이지로 리다이렉트
    header("Location: login.php");
    exit();
}

// 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 성공</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <h2>☁️환영합니다, <?php echo $user_id; ?>!☁️</h2>
        <p>로그인에 성공했습니다. 게시판을 이용하세요!</p>
        <a class="login-button" href="board.php">게시판</a>
        <a class="signup-link" href="logout.php">로그아웃</a>
    </div>
</body>
</html>
