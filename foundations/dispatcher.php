<?php 
    class Dispatcher {
        public $name = "";
        public $output = null;
        public $wrap = false;
        public $requestdata = array();
        public $pagetitle = "";
        public $outputmode = "managed";

        function __construct($requestdata) {
            $this->requestdata = $requestdata;

            foreach(Configuration::modules as $module=>$module_conf){

                // alert exception when doesn exist

                extract($module_conf,EXTR_OVERWRITE);
                require_once(__FD_DIR . "modules/{$module}.php");
            }
        }

        function render() {
            if($this->output == null)
                throw new Exception("No \"{$this->name}\" dispatcher override found");
        }

        function flush() {
            if($this->outputmode == "direct"){
                echo $this->output;
            }else{
                header("Content-Type: application/json");
                echo json_encode(array(
                    "pagetitle" => $this->pagetitle,
                    "output" => $this->output
                ));
            }
        }

    }
?>