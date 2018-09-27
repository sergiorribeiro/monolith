<?php
    class HomeDispatcher extends NavPageDispatcherType {

        function __construct($requestdata) {
            $this->name = "home";
            $this->mainmarkup = "home";
            $this->pagetitle = "monolith::Home";
            parent::__construct($requestdata);
        }

        function pagedata() {
            global $_db;

            $data = array(
                "description" => "PHP developers friendly, hybrid single page application framework"
            );

            // All your data are belong to here (yeah, grammar error intended. l2meme)

            return $data;
        }

    }
?>