<?php
$servername = "localhost"; // MySQL 서버 주소
$username = "root"; // MySQL 사용자 이름
$password = ""; // MySQL 비밀번호
$dbname = "user_management"; // 사용할 데이터베이스 이름

$conn = new mysqli($servername, $username, $password, $dbname); // MySQL 데이터베이스에 연결

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // 연결에 실패하면 에러를 출력하고 종료

$registration_status = ''; //회원가입 상태를 저장하는 변수를 초기화

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['new_username']) && isset($_GET['new_password'])) {
    // GET 요청이고 새로운 사용자명과 비밀번호가 설정되어 있는 경우

		$new_username = $_GET['new_username']; // 새로운 사용자명을 가져옴
    $new_password = $_GET['new_password']; // 새로운 비밀번호 가져옴

    // 아이디 중복 확인
    $check_duplicate_sql = "SELECT * FROM users WHERE username = '$new_username'";
    $duplicate_result = $conn->query($check_duplicate_sql);

    if ($duplicate_result->num_rows > 0) {
        // 아이디가 이미 존재하는 경우
        $registration_status = 'duplicate';
    } else {
        // 아이디가 중복되지 않는 경우, 데이터베이스에 추가
        $insert_user_sql = "INSERT INTO users (username, password) VALUES ('$new_username', '$new_password')";

        if ($conn->query($insert_user_sql) === TRUE) {
						// 회원가입이 성공적으로 완료된 경우
            $registration_status = 'success';
        } else {
						// 회원가입 중 오류가 발생한 경우
            $registration_status = 'failure';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
      <h2>☁️Sign Up☁️</h2>
        <?php if (isset($registration_status) && $registration_status !== '') { ?>
            <?php if ($registration_status === 'success') { ?>
                <p style="color: green;">회원가입이 성공적으로 완료되었습니다!</p>
            <?php } elseif ($registration_status === 'duplicate') { ?>
                <p style="color: red;">이미 존재하는 아이디입니다.</p>
            <?php } else { ?>
                <p style="color: red;">회원가입 중 오류가 발생했습니다. 다시 시도해주세요.</p>
            <?php } ?>
        <?php } ?>
        <form class="signup-form" action="signup.php" method="GET">
            <input class="form-input" type="text" name="new_username" placeholder="New Username" required />
            <input class="form-input" type="password" name="new_password" placeholder="New Password" required />
            <button class="signup-button" type="submit">sign up</button>
            <a class="gologin-link" href="login.php">로그인하러가기</a>
        </form>
    </div>
</body>
</html>