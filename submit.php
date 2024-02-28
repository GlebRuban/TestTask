<?php

// Проверка на отправку данных 

if(isset($_SESSION['submitted']) && $_SESSION['submitted'] == true) {
    header("Location: error.php");
    exit();
}

// Проверка на существование
if(isset($_POST['name']) && isset($_POST['phone']) && preg_match("/^+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/", $_POST['phone'])) {
    $data = [
        'stream_code' => 'iu244',
        'client' => [
            'name' => $_POST['name'],
            'phone' => $_POST['phone']
        ],
        'sub1' => $_POST['hidden_field']
    ];

    $ch = curl_init('https://order.drcash.sh/v1/order');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer NWJLZGEWOWETNTGZMS00MZK4LWFIZJUTNJVMOTG0NJQXOTI3'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    if($response === 'Success') {
        $_SESSION['submitted'] = true;
        header("Location: success.php");
        exit();
    } else {
        header("Location: error.php");
        exit();
    }
} else {
    header("Location: error.php");
    exit();
}
?>