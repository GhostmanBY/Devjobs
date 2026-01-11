<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class login {
    private ReadRegister $rr;

    public function __construct(){
        $this->rr = new ReadRegister();
    }

    public function auth_login(array $body): ?array{
        try {
            if (empty($body)) {
                throw new HttpException(404, 'Los datos enviados no son precisos');
            }
            $data = $this->rr->auth_login($body);

            $secret = JWT_SECRET;
            $issuedAt = time();
            $expire = $issuedAt + 3600; // 1 hora

            $payload = [
                "iat" => $issuedAt,
                "exp" => $expire,
                "sub" => $data["id"],
                "name" => $data["username"]
            ];

            $jwt = JWT::encode($payload, $secret, "HS256");
            $this->__seter_cookies__($jwt);

            return [
                "success" => true,
                "username" => $data["username"]
            ];
        } catch (HttpException $e) {
            http_response_code(404);
            echo json_encode(['Error' => $e->getMessage()]);
            exit;
        }
    }
    
    private function __seter_cookies__($jwt) {
        setcookie(  
            "token",
            $jwt,
            [
                "expires" => time() + 3600,
                "path" => "/",
                 'secure' => false,
                "httponly" => true,   // JS no accede
                "samesite" => "Lax"
            ]
        );
    }
}
?>