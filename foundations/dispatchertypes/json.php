<?php 
    class JsonDispatcherType extends Dispatcher {

        function dispatch() {
            header("Content-Type: application/json");
            echo json_encode($this->output);
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }
        
    }
?>