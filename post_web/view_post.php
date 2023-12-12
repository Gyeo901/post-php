<?php
session_start();

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];

// 게시물 ID 가져오기
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // 게시물 조회
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_management";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($sql);

    $conn->close();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $post_title = $row['title'];
        $post_content = $row['content'];
        $post_user_id = $row['user_id'];
        $post_created_at = $row['created_at'];
    } else {
        echo "게시물을 찾을 수 없습니다.";
        exit();
    }
} else {
    echo "게시물을 찾을 수 없습니다.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📃게시물 보기📃</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <h2><?php echo $post_title; ?></h2>
        <p><?php echo $post_content; ?></p>
        <p>작성자: <?php echo $post_user_id; ?> - 작성일: <?php echo $post_created_at; ?></p>
        <hr>
        <a class="login-button" href="board.php">게시판으로 돌아가기</a>
        <a class="signup-link" href="logout.php">로그아웃</a>
    </div>
</body>
</html>
