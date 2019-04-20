<?php
    class NavPageDispatcherType extends Dispatcher {
        public $pagetitle = "";
        public $mainmarkup = "";

        function dispatch() {
            ob_start();
            extract($this->pagedata(),EXTR_OVERWRITE);
            require __AP_DIR . "/" . Configuration::navigationPagesFolder . "/{$this->name}/{$this->mainmarkup}.php";
            $this->output = ob_get_contents();
            ob_end_clean();

            header("Content-Type: application/json");

            if(stripos($this->output,"<!--//MLEXCEPTION//-->") !== false){
                preg_match_all('/MLEXCEPTION\[(.*)]/m', $this->output, $matches, PREG_SET_ORDER, 0);
                if(count($matches) > 0){
                    throw new Exception($matches[0][1]);
                }
            }

            echo json_encode(array(
                "pagetitle" => $this->pagetitle,
                "output" => str_replace("{{APP}}",baseUrl(array("application")),$this->output)
            ));
            die();
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }
    }
?>