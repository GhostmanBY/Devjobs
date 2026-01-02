<?php
declare(strict_types=1);
require_once __DIR__ . '/config/database.class.php';
require_once __DIR__ . '/utils/HttpException.php';
require_once __DIR__ . '/routes.php';
require_once __DIR__ . '/controllers/register.php';
require_once __DIR__ . '/controllers/login.php';
require_once __DIR__ . '/services/WirteRegister.php';
require_once __DIR__ . '/services/ReadRegister.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://127.0.0.1:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$router = new Router();

$router->add('GET', '/', function() {
    http_response_code(200);
    echo json_encode('Bienvenido al API de DevJobs');
});

$router->add('POST', '/register/worker', function ($body) {
    $register = new Register();
    $register->load_data_user($body);
});

$router->add('POST', '/register/company', function ($body) {
    $register = new Register();
    $register->load_data_comany($body);
});

$router->add('POST', '/auth/login', function ($body) {
    $login = new login();
    $data = $login->auth_login($body);

    echo json_encode($data);
});

$router->run();
?>