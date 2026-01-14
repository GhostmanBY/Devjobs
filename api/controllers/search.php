<?php
    class Search{
        private ReadRegister $RR;   
        private int $page; 
        private int $page_limit; 
        private array $Jobs; 

        public function __construct($page, $page_limit) {
            $this->RR = new ReadRegister();
            $this->page = $page;
            $this->page_limit = $page_limit;
            $this->Jobs = array(); 

        }

        public function search_jobs() {
            try {
                if ($this->page === null || $this->page <= 0) {
                    throw new HttpException(404, "Valores negativos o incompletos, pagina");
                };
                if ($this->page_limit === null || $this->page_limit <= 0) {
                    throw new HttpException(404, "Valores negativos o incompletos, limite de paginas");
                };

                $this->Jobs = $this->RR->search_jobs($this->page, $this->page_limit);

                return $this->Jobs;
            } catch (HttpException $e) {
                $errorData = ["Error" => "El error causado ocurrio por: " . $e->getMessage()];
                echo json_encode($errorData);
            };
        }
    }
?>