<?php 
    class FileDownloadDispatcherType extends Dispatcher {
        public $mime = "";
        public $filename = "";
        public $filepath = "";

        function dispatch() {
            header("Content-Description: File Transfer");
            header("Content-Type: {$this->mime}");
            header("Content-Disposition: attachment; filename=\"{$this->filename}\""); 
            header("Content-Transfer-Encoding: binary");
            header("Connection: Keep-Alive");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
            header("Content-Length: " . filesize($this->filepath));
            readfile($this->filepath);
            die();
        }

        function __construct($requestdata) {
            parent::__construct($requestdata);
        }
    }
?>