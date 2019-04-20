<?php
    define("MONOLITH_MANAGED",true);
    define("__FD_DIR",dirname(__FILE__) . "/foundations/");
    define("__AP_DIR",dirname(__FILE__) . "/application/");
    define("__RUNID",uniqid());
    define("__CONFIG_FILE",dirname(__FILE__) . "/config.php");
    require("foundations/cornerstone.php");
?>