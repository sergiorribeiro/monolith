<?php 
    class RawDispatcherType extends Dispatcher {

        function dispatch() {
            echo $this->output;
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }
        
    }
?>