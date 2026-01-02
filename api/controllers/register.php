<?php
declare(strict_types=1);

class Register {
    private WirteRegister $wr;

    public function __construct(){
        $this->wr = new WirteRegister();
    }

    public function load_data_user (array $body) : void {
        try {
            if ($body === NULL || $body === []) {
                throw new HttpException(404, 'Los datos enviados no son precisos');
            } 
            $this->wr->save_date_worker($body);
        }
        catch (HttpException $e) {
            http_response_code(404);
            json_encode(['Error' => $e->getMessage()]);
            exit;
        }
    }

    public function load_data_comany (array $body) : void {
        try {
            if ($body === NULL || $body === []) {
                throw new HttpException(404, 'Los datos enviados no son precisos');
            } 
            $this->wr->save_date_company($body);
            http_response_code(200);
            echo json_encode([
                'message' => 'Compania registrado correctamente'
            ]);
        }
        catch (HttpException $e) {
            http_response_code(404);
            json_encode(['Error' => $e->getMessage()]);
            exit;
        }
    }
}
?>