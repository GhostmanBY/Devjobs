<?php
class login {
    private ReadRegister $rr;

    public function __construct(){
        $this->rr = new ReadRegister();
    }

    public function auth_login(array $body): ?array{
        try {
            if ($body  === NULL || $body === []) {
                throw new HttpException(404, 'Los datos enviados no son precisos');
            }
            $data = $this->rr->auth_login($body);
            return $data;
        } catch (HttpException $e) {
            http_response_code(404);
            json_encode(['Error' => $e->getMessage()]);
            exit;
        }
    }
}
?>