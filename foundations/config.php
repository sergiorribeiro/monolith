<?php
    class Configuration {
        const defaultDispatcher = "home";
        const omitDefaultRoute = true;
        const allowSamePageNavigation = false;
        const packableScriptFolders = array("pages");
        const routes = array(
            "home" => array("type" => "nav", "dispatcher" => "home"),
            "custom/sample/route" => array("type" => "raw", "dispatcher" => "custom")
        );
        const pluggables = array(
            "hyperdux" => array(
                "databaseHost" => "localhost",
                "databaseName" => "lbd",
                "databaseUsername" => "root",
                "databasePassword" => ""
            ),
            "smtpmailer" => array(
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