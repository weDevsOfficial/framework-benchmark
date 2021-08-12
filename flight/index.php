<?php
require 'vendor/autoload.php';

use flight\Engine;

$app = new Engine();

// Register class with constructor parameters
$app->register('db', 'PDO', array('mysql:host=localhost;dbname=framework_benchmark','root','root'));

$app->route('/', function () {
    return Flight::json([
        'success' => true,
        'message' => 'Hello World'
    ]);
});

$app->route('/users', function () use ($app) {
    $db = $app->db();

    $sth = $db->prepare("SELECT name, email FROM users WHERE email LIKE '%example.com%'");
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    return Flight::json($result);
});

$app->route('/compute', function () {
    $x = 0;
    $y = 1;
    $max = 10000;

    for ($i = 0; $i <= $max; $i++) {
        $z = $x + $y;
        $x = $y;
        $y = $z;
    }

    return Flight::json([
        'status' => 'done',
    ]);
});


$app->start();
