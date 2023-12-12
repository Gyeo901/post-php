<?php
session_start(); // 세션 시작

$servername = "localhost"; // MySQL 서버 주소
$username = "root"; // MySQL 사용자 이름
$password = ""; // MySQL 비밀번호
$dbname = "user_management"; // 사용할 데이터베이스 이름

$conn = new mysqli($servername, $username, $password, $dbname); // MySQL 데이터베이스에 연결

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // 연결에 실패하면 에러를 출력하고 종료

$login_status = ''; //로그인 상태를 저장하는 변수를 초기화

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username']) && isset($_GET['password'])) {
    // GET 요청이고 사용자명과 비밀번호가 설정되어 있는 경우

		$entered_username = $_GET['username']; // 입력된 사용자명을 가져옴
    $entered_password = $_GET['password']; // 입력된 비밀번호를 가져옴

    $sql = "SELECT * FROM users WHERE username = '$entered_username' AND password = '$entered_password'";
    // 입력된 사용자명과 비밀번호를 사용하여 데이터베이스에서 사용자를 조회하는 SQL 쿼리를 생성
		
		$result = $conn->query($sql); // SQL 쿼리를 실행하고 결과를 가져옴

    if ($result && $result->num_rows > 0) {
				// 쿼리 결과가 있고 사용자가 존재하는 경우

				// 로그인 성공시 세션에 사용자 ID를 저장
        $_SESSION['user_id'] = $entered_username;

				// 로그인 성공 페이지로 리다이렉트
        header("Location: success.php");
        exit();
    } else {
				// 사용자가 존재하지 않는 경우 로그인 실패 상태를 설정
        $login_status = 'failure';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <h2>☁️Login☁️</h2>
        <?php
        if ($login_status === 'failure') {
						// 로그인 실패 상태가 설정되어 있는 경우 에러 메시지를 출력
            echo '<p style="color: red;">아이디 또는 비밀번호가 일치하지 않습니다. 다시 입력해주세요.</p>';
        }
        ?>
        <form class="login-form" action="login.php" method="GET">
            <input class="form-input" type="text" name="username" placeholder="Username" required />
            <input class="form-input" type="password" name="password" placeholder="Password" required />
            <button class="login-button" type="submit">Login</button>
        </form>
        <a class="signup-link" href="signup.php">회원가입</a>


    </div>
</body>
</html>