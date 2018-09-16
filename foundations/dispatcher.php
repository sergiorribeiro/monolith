<?php 
    class Dispatcher {
        public $name = "";
        public $output = null;
        public $requestdata = array();

        function __construct($requestdata) {
            $this->requestdata = $requestdata;

            foreach(Configuration::pluggables as $pluggable=>$pluggable_conf){
                $pluggablepath = __FD_DIR . "pluggables/{$pluggable}.php";
                if(!file_exists($pluggablepath))
                    throw new Exception("Unable to load pluggable \"{$pluggable}\": file not found");
                extract($pluggable_conf,EXTR_OVERWRITE);
                require_once($pluggablepath);
            }
        }

        function dispatch() {
            throw new Exception("No \"{$this->name}\" dispatch override found");
        }
    }
?>