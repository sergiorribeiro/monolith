<?php
    class Configuration {
        const showExceptions = true;
        const defaultDispatcher = "home";
        const omitDefaultRoute = true;
        const allowSamePageNavigation = false;
        const packableScriptFolders = array("pages");
        const routes = array(
            "home" => array("type" => "nav", "dispatcher" => "home"),
            "custom/sample/route" => array("type" => "raw", "dispatcher" => "custom"),
            "raw" => array("type" => "raw", "dispatcher" => "raw")
        );
        const pluggables = array(
            "hyperdux" => array(
                "enabled" => false,
                "databaseHost" => "localhost",
                "databaseName" => "lbd",
                "databaseUsername" => "root",
                "databasePassword" => ""
            ),
            "smtpmailer" => array(
                "enabled" => false,
                "smtpHost" => "localhost",
                "smtpAuth" => false,
                "smtpUser" => "",
                "smtpPassword" => "",
                "smtpSecure" => "",
                "smtpPort" => 25
            )
        );
    }
?>