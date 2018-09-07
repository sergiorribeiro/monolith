<?php
    class hyperdux{
        private $pdo = null;
        function __construct($srv,$dbn,$usr,$pwd,$timeout = 30,$charset = "utf8"){
            $this->pdo = new PDO("mysql:host=$srv;dbname=$dbn;charset=$charset", $usr, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_TIMEOUT,$timeout);
            $this->pdo->exec("SET names $charset");
        }
        private function createCommand($q,$params){
            $command = $this->pdo->prepare($q);
            foreach($params as $pk=>$pv){
                    if(is_int($pv))
                        $type = PDO::PARAM_INT;
                    elseif(is_bool($pv))
                        $type = PDO::PARAM_BOOL;
                    elseif(is_null($pv))
                        $type = PDO::PARAM_NULL;
                    else
                        $type = PDO::PARAM_STR;
                $command->bindValue($pk, $pv, $type);
            }
            return $command;
        }
        public function query($q,$params = array()){
            $command = $this->createCommand($q,$params);
            $qs = $command->queryString;
            if($command->execute() === false){
                $err = $command->errorInfo();
                throw new Exception("\"$qs\" failed: {$err[0]}: {$err[2]}");
            }
            return new duxResult($command,$this->pdo);
        }
        public function nonquery($q,$params = array()){
            $dr = $this->query($q,$params);
            return $dr->affectedCount();
        }
        public function insert($table,$values){
            $cols = array();
            $vars = array();
            $vals = array();
            foreach($values as $k=>$v){
                array_push($cols,$k);
                $vals = array_merge($vals,array($k=>$v));
            }
            $vars = implode(",",array_map(function($v){return ":$v";},$cols));
            $cols = implode(",",$cols);
            $table = str_replace(".","`.`",$table);
            $q = "INSERT INTO `$table` ($cols) VALUES($vars);";
            $dr = $this->query($q,$vals);
            return $this->pdo->lastInsertId();
        }
        public function scalar($q,$params = array()){
            $dr = $this->query($q,$params);
            return $dr->scalar();
        }
        public function beginTransaction(){
            $this->pdo->beginTransaction();
        }
        public function commitTransaction(){
            $this->pdo->commit();
        }
        public function rollbackTransaction(){
            $this->pdo->rollBack();
        }
    }
    class duxResult{
        private $affected = 0;
        private $insertId = 0;
        private $result = array();
        function __construct($command,&$pdo){
            $this->affected = $command->rowCount();
            $this->insertId = $pdo->lastInsertId();
            $this->result = $command->fetchAll();
        }
        public function scalar(){
            if($this->rowCount()>0)
                return $this->result[0][0];
            return null;
        }
        public function getAll(){
            return $this->result;
        }
        public function rowCount(){
            return count($this->result);
        }
        public function affectedCount(){
            return $this->affected;
        }
        public function insertId(){
            return $this->insertId;
        }
    }

    global $_db;
    $_db = new hyperdux(
        $databaseHost,
        $databaseName,
        $databaseUsername,
        $databasePassword);
?>