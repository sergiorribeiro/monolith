<?php
    $nodes = isset($_GET['path']) ? explode("/",$_GET['path']) : array();
    $page = count($nodes) > 0 ? $nodes[0] : Configuration::defaultPage;
    $parametricpage = NULL;
    $params = array(
        "page" => $page,
        "params" => array_slice($nodes, 1),
        "postdata" => $_POST
    );

    if(strtolower($page) == "static"){
        $parametricpage = $params['params'][0];
        if($d = dispatcherAvailable($parametricpage))
            processDispatcher($d,$parametricpage,$params);
    }elseif(isset($_POST['monolith_navigation'])){
        if($d = dispatcherAvailable($page))
            processDispatcher($d,$page,$params);
    }else{
        processDispatcher(__AP_DIR . "wrapper/dispatcher.php","wrapper",$params);
    }

    if(strtolower($page) == "static")
        $page = $params['params'][0];

    throw new Exception("Dispatcher is missing for page \"$page\"");

    function dispatcherAvailable($dispatcher) {
        $dispatchers = array_filter(glob(__AP_DIR . "dispatchers/*"), "is_file");
        foreach($dispatchers as $d){
            $dn = $d;
            $dn = strtolower(substr($dn,strripos($dn,"/") + 1));
            $dn = str_replace(".php","",$dn);
            if($dn == strtolower($dispatcher)){return $d;}
        }
        return false;
    }

    function processDispatcher($dispatcher,$dispatchername,$requestdata) {
        require_once($dispatcher);
        $dispatcherClassName = ucfirst($dispatchername) . "Dispatcher";
        $dispatcherInstance = new $dispatcherClassName($requestdata);
        $dispatcherInstance->render();
        $dispatcherInstance->flush();
        exit;
    }
?>