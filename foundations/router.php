<?php
    $nodes = isset($_GET['path']) ? explode("/",$_GET['path']) : array();
    $route = implode("/",$nodes);
    $dispatchername = count($nodes) > 0 ? $nodes[0] : Configuration::defaultDispatcher;
    if($route == "")
        $route = $dispatchername;
    $params = array(
        "path" => isset($_GET['path']) ? $_GET['path'] : $dispatchername,
        "postdata" => $_POST,
        "getdata" => $_GET,
        "filedata" => $_FILES,
        "cookie" => $_COOKIE
    );

    $routedata = array("type" => "nav","dispatcher" => $dispatchername);

    foreach(Configuration::routes as $knownroute => $data) {
        if(stripos($route,$knownroute) === 0){
            $routedata = $data;
            $strippedpath = ltrim(str_replace($knownroute,"",$route),"/");
            $params['params'] = explode("/",$strippedpath);
            $params['path'] = $knownroute . "/" . $strippedpath;
            break;
        }
    }

    if(isset($_POST['monolith_navigation']) || $routedata['type'] == "raw"){
        if($d = dispatcherExists($routedata['dispatcher']))
            processDispatcher($d,$routedata['dispatcher'],$routedata['dispatcher'],$params);
        else
            invalidRoute($route);
    }else{
        if(dispatcherExists($routedata['dispatcher']))
            processDispatcher(__FD_DIR . "wrapperdispatcher.php", $routedata['dispatcher'], "wrapper" ,$params);
        else
            invalidRoute($route);
    }

    function dispatcherExists($dispatcher) {
        $dispatcherPath = __AP_DIR . Configuration::dispatchersFolder . "/{$dispatcher}.php";
        if(file_exists($dispatcherPath))
            return $dispatcherPath;
        return false;
    }

    function processDispatcher($dispatcher,$dispatchername,$dispatcherclass,$requestdata) {
        require_once($dispatcher);
        $requestdata['page'] = $dispatchername;
        $dispatcherClassName = ucfirst($dispatcherclass) . "Dispatcher";
        $dispatcherInstance = new $dispatcherClassName($requestdata);
        $dispatcherInstance->dispatch();
        exit;
    }

    function invalidRoute($route){
        if(Configuration::showExceptions)
            throw new Exception("No \"{$this->name}\" dispatch override found");

        require __AP_DIR . "/errors/404.php";
    }
?>