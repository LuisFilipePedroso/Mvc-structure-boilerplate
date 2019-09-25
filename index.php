<?php

require ('./src/connection/index.php');

$conn = connect();

if($conn) {
    echo "The connection was established successfully\nExample of get on users table:";

    $sql = 'SELECT * FROM users';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    var_dump($result);
} else {
    echo 'Fail on connect';
}