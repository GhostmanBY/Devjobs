<?php
declare(strict_types=1);
define('JWT_SECRET', '7f8c9a1b5d3e4a6f9b0c2d1e8a7f6c5b9d4e3a2f1c0b8a7e6d5c4b3a2f1');

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.class.php';
require_once __DIR__ . '/utils/HttpException.php';
require_once __DIR__ . '/routes.php';
require_once __DIR__ . '/controllers/register.php';
require_once __DIR__ . '/controllers/login.php';
require_once __DIR__ . '/services/WirteRegister.php';
require_once __DIR__ . '/services/ReadRegister.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

header("Access-Control-Allow-Origin: $origin"); 

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
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

$router->add('GET', '/auth/login/verific', function () {
    if (!isset($_COOKIE["token"])) {
        http_response_code(401);
        echo json_encode(["error" => $_COOKIE]);
        exit;
    }

    try {
        $decoded = JWT::decode(
            $_COOKIE["token"],
        new Key(JWT_SECRET, "HS256")
        );
        http_response_code(200);
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido"]);
        exit;
    }
});

$router->run();
?>