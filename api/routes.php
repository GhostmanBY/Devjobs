<?php
class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function run(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $body = json_decode(file_get_contents("php://input"), true ?? []);

        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri], $body);
            return;

        }else {
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
        }
    }
}

?>