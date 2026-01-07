<?php
declare(strict_types=1);

class ReadRegister {
    private DB $db;

    public function __construct(){
        $this->db = new DB();
    }

    public function auth_login(array $body){
        $pdo = $this->db->get_db();

        $stmt = $pdo->prepare("CALL sp_validate_email(:email)");
        $stmt->execute(['email' => $body["email"]]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->closes_cursor($stmt);

        if ($user !== false) {
            if (!password_verify($body["password"], $user["hash_password"])) {
                http_response_code(401);
                echo json_encode(["error" => "Credenciales inválidas"]);
                exit;
            }else {
                $stmt = $pdo->prepare("CALL sp_serch_id_worker(:id)");
                $stmt->execute(['id' => $user["id"]]);
                $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->db->closes_cursor($stmt);
                //error de que no tiene la column mail el disc user_data y debuguear en este archivo agregando DB para que funcione
                $data = [
                    "success" => true,
                    "id" => $user["id"],
                    "username" => $user_data["name"],
                    "email" => $user_data["email"]
                ];
                http_response_code(200);
                return $data;
            }
        }else{
            http_response_code(401);
            echo json_encode(["error" => "Correo inexistente"]);
            exit;
        }
        
    }
}
?>