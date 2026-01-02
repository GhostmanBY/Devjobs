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

        if (!$user === false) {
            $data_user = [
                "id" => $user["id"],
                "role" => $user["role"]
            ];
            if (!password_verify($body["password"], $user["hash_password"])) {
                http_response_code(401);
                echo json_encode(["error" => "Credenciales inválidas"]);
                exit;
            }else {
                http_response_code(200);
                return $data_user;
            }
        }else{
            http_response_code(404);
            echo json_encode(["error" => "Correo inexistente"]);
        }
        
    }
}
?>