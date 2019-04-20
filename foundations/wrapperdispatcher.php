<?php
    class WrapperDispatcher extends RawDispatcherType {

        public $scripts = array();

        function dispatch() {
            parent::dispatch();
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }

        function content(){
            ob_start();
            require_once __AP_DIR . Configuration::wrapperMarkup;
            $this->output = ob_get_contents();
            ob_end_clean();

            $scriptpack = "";

            foreach(Configuration::packableScriptFolders as $target){
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__AP_DIR . $target), RecursiveIteratorIterator::SELF_FIRST);
                foreach($iterator as $name => $file){
                    if (pathinfo($name, PATHINFO_EXTENSION) == "js") {
                        $scriptpack .= file_get_contents($name);
                    }
                }
            }

            $reps = array(
                "PAGE" => $this->requestdata['page'],
                "SCRIPTPACK" => $scriptpack,
                "OMIT_DEFAULT_ROUTE" => Configuration::omitDefaultRoute,
                "DEFAULT_DISPATCHER" => Configuration::defaultDispatcher,
                "AP_DIR" => baseURL(array("application")),
                "FD_DIR" => baseURL(array("foundations"))
            );

            foreach($reps as $key => $value)
                $this->output = str_replace("{{{$key}}}",$value,$this->output);
        }

    }
?>