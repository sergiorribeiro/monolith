<?php 
    class HomeDispatcher extends NavPageDispatcherType {

        function __construct($requestdata) {
            $this->name = "home";
            $this->pagetitle = "monolith::Home";
            parent::__construct($requestdata);
        }

        function dispatch() {
            ob_start();
            echo $this->content();
            $this->output = ob_get_contents();
            ob_end_clean();
            parent::dispatch();
        }

        function content(){
            global $_db;
            
            $data = array(
                "description" => "PHP developers friendly, hybrid single page application framework"
            );

            // All your data are belong to here (yeah, grammar error intended. l2meme)
            
            extract($data,EXTR_OVERWRITE);
            require __AP_DIR . "/pages/{$this->name}/main.php";
        }

    }
?>