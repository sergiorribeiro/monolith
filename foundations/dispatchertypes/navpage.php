<?php 
    class NavPageDispatcherType extends Dispatcher {
        public $pagetitle = "";

        function dispatch() {
            header("Content-Type: application/json");
            echo json_encode(array(
                "pagetitle" => $this->pagetitle,
                "output" => $this->output
            ));
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }
        
    }
?>