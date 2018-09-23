<?php 
    set_exception_handler("exception_handler");
    set_error_handler("error_handler");
    require_once(__FD_DIR . "config.php");
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
        die();
    }
?>