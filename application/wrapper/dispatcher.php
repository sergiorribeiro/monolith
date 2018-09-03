<?php 
    class WrapperDispatcher extends Dispatcher {
        
        public $scripts = array();

        function render() {
            $this->content();
            parent::render();
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
            $this->outputmode = "direct";
        }

        function content(){
            ob_start();
            require_once __AP_DIR . "/wrapper/markup.php";
            $this->output = ob_get_contents();
            ob_end_clean();

            $scriptpack = "";

            foreach(array("pages","vertical") as $target){
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__AP_DIR . $target), RecursiveIteratorIterator::SELF_FIRST);
                foreach($iterator as $name => $file){
                    if (pathinfo($name, PATHINFO_EXTENSION) == "js") {
                        $scriptpack .= file_get_contents($name);
                    }
                }
            }
            
            $reps = array(
                "PAGE" => $this->requestdata['page'],
                "SCRIPTPACK" => $scriptpack
            );

            foreach($reps as $key => $value)
                $this->output = str_replace("{{{$key}}}",$value,$this->output);
        }

    }
?>