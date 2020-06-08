<?php
    $subject = $_SESSION['subject'];
    $comment = $_SESSION['comment'];
    $email = $_SESSION['email'];
?>

<html>
    <body>
        <h1><?=$subject?></h1>
        <p><?=$comment?></p><br/><br/>
        de : <i style="color: blue"><?=$email?></i>
    </body>
</html>
