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

            file_put_contents(__AP_DIR . Configuration::packedScriptsLocation . "/pack.js", $scriptpack);

            $reps = array(
                "PAGE" => $this->requestdata['page'],
                "ROUTE" => $this->requestdata['path'],
                "OMIT_DEFAULT_ROUTE" => Configuration::omitDefaultRoute,
                "DEFAULT_DISPATCHER" => Configuration::defaultDispatcher,
                "ALLOW_SAME_PAGE_NAV" => Configuration::allowSamePageNavigation,
                "AP_DIR" => baseURL(array("application")),
                "FD_DIR" => baseURL(array("foundations"))
            );

            $reps = array_merge($reps,Configuration::wrapperConstants);

            foreach($reps as $key => $value)
                $this->output = str_replace("{{{$key}}}",$value,$this->output);
        }

    }
?>