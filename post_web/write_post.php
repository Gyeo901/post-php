<?php
session_start();

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];

// 게시물 작성 처리
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        // 게시물이 성공적으로 작성되었으면, 게시판 페이지로 리다이렉션
        header("Location: board.php");
        exit();
    } else {
        echo "게시물 작성 실패: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Post</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <h2>📃게시물 작성하기📃</h2>
        <form action="write_post.php" method="POST">
            <label for="title">제목:</label>
            <input type="text" name="title" required><br>
            <label for="content">내용:</label>
            <textarea name="content" rows="4" required></textarea><br>
            <button type="submit">게시물 작성</button>
        </form>
        <br>
        <a class="login-button" href="board.php">게시판으로 돌아가기</a>
        <a class="signup-link" href="logout.php">로그아웃</a>
    </div>
</body>
</html>
