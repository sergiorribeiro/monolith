<?php
    set_exception_handler("exception_handler");
    set_error_handler("error_handler");
    require_once(__CONFIG_FILE);
    require_once(__FD_DIR . "dispatcher.php");

    $dispatchertypes = array_filter(glob(__FD_DIR . "dispatchertypes/*.php"), "is_file");
    foreach($dispatchertypes as $dt){
        require_once($dt);
    }

    require_once(__FD_DIR . "router.php");

    function exception_handler($exception) {
        genericErrorHandler(
            -1,
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
    }

    function error_handler($no, $str, $file, $line) {
        genericErrorHandler($no,$str,$file,$line,"");
    }

    function genericErrorHandler($ERRNO, $ERRMSG, $ERRFILE, $ERRLINE, $ERRTRACE){
        ob_start();
        require(__FD_DIR . "pages/exception.php");
        $exceptionmarkup = ob_get_contents();
        ob_end_clean();
        echo str_replace("{{WHAT}}","PHP Error",$exceptionmarkup);
    }

    function wrapperInjection($part) {
        switch($part) {
            case "head":
                require(__FD_DIR . "wrapperheadinc.php");
                break;
            case "body":
                require(__FD_DIR . "wrapperbodyinc.php");
                break;
            case "scriptpack":
                ?><script type="text/javascript" src="<?=baseURL(array("application",Configuration::packedScriptsLocation,"pack.js"))?>"></script><?php
                break;
        }
    }

    function baseURL($nodes = array()) {
        $base = Configuration::applicationBaseUrl;
        foreach($nodes as $node)
            $base .= "/$node";
        while(stripos($base,"//") !== FALSE)
            $base = str_replace("//","/",$base);
        return $base;
    }
?>