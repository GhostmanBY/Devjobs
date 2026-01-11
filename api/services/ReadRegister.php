<?php
declare(strict_types=1);

class ReadRegister {
    private DB $db;

    public function __construct(){
        $this->db = new DB();
    }

    public function auth_login(array $body): array {
        $pdo = $this->db->get_db();

        $stmt = $pdo->prepare("CALL sp_validate_email(:email)");
        $stmt->execute(['email' => $body["email"]]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->closes_cursor($stmt);

        if ($user === false) {
            throw new HttpException(401, "Correo inexistente");
        }

        if (!password_verify($body["password"], $user["hash_password"])) {
            throw new HttpException(401, "Credenciales inválidas");
        }

        $stmt = $pdo->prepare("CALL sp_serch_id_worker(:id)");
        $stmt->execute(['id' => $user["id"]]);

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->closes_cursor($stmt);

        return [
            "success"  => true,
            "id"       => $user["id"],
            "username" => $user_data["name"] ?? null,
            "email"    => $user_data["email"] ?? null
        ];
    }
    
}
?>