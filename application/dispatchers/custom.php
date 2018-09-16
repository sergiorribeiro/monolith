<?php 
    class CustomDispatcher extends JsonDispatcherType {

        function __construct($requestdata) {
            $this->name = "home"; 
            parent::__construct($requestdata);
        }

        function dispatch() {
            $this->output = $this->content();
            parent::dispatch();
        }

        function content(){
            global $_db;
            
            return array("some","sample","data");
        }

    }
?>