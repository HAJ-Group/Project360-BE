<?php

session_start();

$sender_emails = [
    ['id' => 'mervelcaroline@gmail.com', 'pass' => 'HQku9Hv9nU'],
    ['id' => 'fedrerojustin@gmail.com', 'pass' => 'jZdWKcXtq'],
    ['id' => 'merrillhiggins0@gmail.com', 'pass' => 'o03UlWsJLN'],
    ['id' => 'tobiasm.simms@gmail.com', 'pass' => 'qN4jjjI5ft'],
    ['id' => 'JeffreyJ.Porcaro@gmail.com', 'pass' => 'r65biwIWRg'],
    ['id' => 'randyrjones33@gmail.com', 'pass' => '6fwXdl8aBz'],
    ['id' => 'darrelljrobinson18@gmail.com', 'pass' => '6QRgfh9zWb'],
    ['id' => 'BryantK.Jacobs@gmail.com', 'pass' => 'q7snEeXhDU'],
    ['id' => 'LonnieA.Warner@gmail.com', 'pass' => 'HEhm8sa9bD'],
    ['id' => 'adamidavis00@gmail.com', 'pass' => 'KTIwo3NbZi'],
    ['id' => 'marksknapp37@gmail.com', 'pass' => 'x0VZn3eanu'],
    ['id' => 'jameslthomas043@gmail.com', 'pass' => 'h1EE40hdYk'],
    ['id' => 'jeffdblack2@gmail.com', 'pass' => 'ND1e9WxvE0'],
    ['id' => 'michaelmsharp3@gmail.com', 'pass' => 'rXrxPxB1Bz'],
    ['id' => 'carladonaldson28@gmail.com', 'pass' => 'KYqZeM8Zqn'],
    ['id' => 'davidcsullivan69@gmail.com', 'pass' => 'N93djncQxS'],
    ['id' => 'AnthonyV.Curd@gmail.com', 'pass' => '6F6404w7rd'],
    ['id' => 'JoeyA.McCullen@gmail.com', 'pass' => 'U7504iDvOp'],
    ['id' => 'GeneN.Plata@gmail.com', 'pass' => '4IOlrrAa8K'],
];

if(empty($_SESSION['sender-delivery'])) {
    $_SESSION['sender-delivery'] = export($sender_emails);
}
else {
    $sender_emails = import($_SESSION['sender-delivery']);
}

function export($data) {
    $to = '';
    foreach ($data as $tmp) {
        $to .= '|' . $tmp['id'] . ':' . $tmp['pass'];
    }
    return substr($to, 1);
}

function import($data) {
    $ret = [];
    $tmp = explode('|', trim($data));
    foreach ($tmp as $item) {
        $v = explode(':', $item);
        array_push($ret, ['id' => $v[0], 'pass' => $v[1]]);
    }
    return $ret;
}


if(empty($_SESSION['sender_length'])) {
    $_SESSION['sender_length'] = count($sender_emails);
    $_SESSION['sender'] = 0;
    $_SESSION['full_counter'] = 0;
    $_SESSION['rotation_value'] = 10;
    $_SESSION['rotation_counter'] = 0;

}
if(empty($_SESSION['from'])) {
    $_SESSION['from'] = 'HMZ';
    $_SESSION['subject'] = 'Test Subject';
    $_SESSION['body'] = '<h1>Hello World</h1>';
}

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => ['address' => 'Project360@app.com', 'name' => $_SESSION['from']],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => $sender_emails[$_SESSION['sender']]['id'],
    'password' => $sender_emails[$_SESSION['sender']]['pass'],
    'sendmail' => '/usr/sbin/sendmail -t',
    'pretend' => false,
];
