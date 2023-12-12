<?php
session_start();

// 세션 삭제
session_unset();
session_destroy();

// 로그인 페이지로 리다이렉션
header("Location: home.php");
exit();
?>
