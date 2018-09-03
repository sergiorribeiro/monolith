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