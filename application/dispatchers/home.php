<?php 
    class HomeDispatcher extends Dispatcher {

        function render() {
            ob_start();
            echo $this->content();
            $this->output = ob_get_contents();
            ob_end_clean();
            parent::render();
        }

        function __construct($requestdata) {
            $this->name = "home";
            $this->pagetitle = "monolith::Home";
            parent::__construct($requestdata);
        }

        function content(){
            global $_db;
            
            $data = array(
                "somevar" => "hey!"
            );

            // All your data are belong to here (yeah, grammar error intended. l2meme)
            
            extract($data,EXTR_OVERWRITE);
            require __AP_DIR . "/pages/{$this->name}/main.php";
        }

    }
?>