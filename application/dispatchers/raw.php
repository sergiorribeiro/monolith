<?php 
    class RawDispatcher extends RawDispatcherType {

        function __construct($requestdata) {
            $this->name = "raw";
            parent::__construct($requestdata);
        }

        function content(){
            global $_db;

            $this->output = "<h1>Hi there!</h1>";
        }

    }
?>