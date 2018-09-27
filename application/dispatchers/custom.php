<?php 
    class CustomDispatcher extends JsonDispatcherType {

        function __construct($requestdata) {
            $this->name = "custom";
            parent::__construct($requestdata);
        }

        function content(){
            global $_db;

            return array("some","sample","data");
        }

    }
?>