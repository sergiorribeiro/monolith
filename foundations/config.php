<?php
    class Configuration {
        const defaultPage = "home";
        const omitDefaultRoute = true;
        const allowSamePageNavigation = false;
        const pluggables = array(
            "hyperdux" => array(
                "databaseHost" => "localhost",
                "databaseName" => "lbd",
                "databaseUsername" => "root",
                "databasePassword" => ""
            )
        );
    }
?>