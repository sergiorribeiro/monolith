<?php
    class Configuration {
        const applicationBaseUrl = "/";
        const showExceptions = false;
        const defaultDispatcher = "home";
        const omitDefaultRoute = true;
        const allowSamePageNavigation = false;
        const packableScriptFolders = array("pages");
        const packedScriptsLocation = "/";
        const navigationPagesFolder = "pages";
        const wrapperMarkup = "wrapper/markup.php";
        const dispatchersFolder = "dispatchers";
        const javascriptConstants = array(
            "message" => "You're all set up!"
        );
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