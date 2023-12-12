<?php
session_start();

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];

// 게시물 목록 조회
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Board</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <h2>📃게시판📃</h2>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h3><a href='view_post.php?id={$row['id']}'>{$row['title']}</a></h3>";
            echo "<p>작성자: {$row['user_id']} - 작성일: {$row['created_at']}</p>";
            echo "</div>";
        }
        ?>
        <hr>
        <a class="login-button" href="write_post.php">작성하기</a>
        <a class="signup-link" href="logout.php">로그아웃</a>
    </div>
</body>
</html>
