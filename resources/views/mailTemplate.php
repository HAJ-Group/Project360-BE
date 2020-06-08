<?php
    $username = $_SESSION['username'];
    $code = $_SESSION['code'];
    $server = 'http://localhost:8000/api/confirm';
?>

<html>
    <body>
        <h1>Confirmation Mail</h1>
        <h1><?=$code?></h1>
        <p>Welcome to our Application, Click this link to confirm your email</p>
        <a href="<?=$server . '/' . $username . '/' . $code ?>">LINK TO CONFIRM</a>
    </body>
</html>
