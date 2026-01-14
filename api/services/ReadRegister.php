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

    public function search_jobs($page, $page_limit) {
        $pdo = $this->db->get_db();

        $stmt = $pdo->prepare("CALL sp_GetSerchPaginated(?, ?, @p_total_pages)");
        $stmt->execute([$page, $page_limit]);

        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db->closes_cursor($stmt);
        
        $outStmt = $pdo->query("SELECT @p_total_pages as total_pages");

        $total_pages_raw = $outStmt->fetchColumn();
        $this->db->closes_cursor($outStmt);
        

        return[
            "jobs" => $jobs,
            "totalPages" => (int)$total_pages_raw,
            "currentPage" => $page
        ];
    }
    
}
?>