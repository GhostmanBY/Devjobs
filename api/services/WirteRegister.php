<?php
declare(strict_types=1);

class WirteRegister {
    private DB $db;

    public function __construct(){
        $this->db = new DB();
    }

    public function save_date_worker(array $body): void{
        try{
            $pdo = $this->db->get_db();
        
            $hash = password_hash($body['password'], PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("CALL sp_insert_users_jobs(?,?,?,?)");
            $stmt->execute([
                $body['name'],
                $body['email'],
                $hash,
                $body['cv']
            ]);
            
            $this->db->closes_cursor($stmt);
            http_response_code(200);
            echo json_encode([
                'message' => 'Usuario registrado correctamente'
            ]);
        } catch (PDOException $e) {
            error_log("DB Error save_date_worker: " . $e->getMessage());

            throw new Exception("Error al registrar el usuario");
        }
    }

    public function save_date_company(array $body): void{
        try{
            $pdo = $this->db->get_db();

            $hash = password_hash($body['password'], PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("CALL sp_insert_user_company(?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $body['name'],
                $body['email'],
                $hash,
                $body['cuilt'],
                $body['rubro'],
                $body['sitoWEB'],
                $body['telefono'],
                $body['direccion']
            ]);
            
            $this->db->closes_cursor($stmt);
            http_response_code(200);
            echo json_encode([
                'message' => 'Compania registrada correctamente'
            ]);
        } catch (PDOException $e) {
            error_log("DB Error save_date_worker: " . $e->getMessage());

            throw new Exception("Error al registrar la compania");
        }
    }
}
?>