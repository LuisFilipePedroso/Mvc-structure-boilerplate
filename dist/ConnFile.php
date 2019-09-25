<?php

class ConnFile {

    private $connection;

    public function createConnFile() {
        $connFile = fopen("./src/connection/index.php", "w") or die("Unable to open file!");
        $line = fwrite($connFile, "<?php\n");
        $line = fwrite($connFile, "
        function connect() {
            \$dsn = 'mysql:host=" . preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/','$1:',$this->connection['host']). ";dbname=" . $this->connection['dbname'] . "';
            \$user = '" . $this->connection['user'] . "';
            \$pass = '" . $this->connection['password'] . "';
            
            try{
                return new PDO(\$dsn, \$user, \$pass);
            }catch (PDOException \$e){
                // report error message
                echo \$e->getMessage();
            }
        }");
    }

    public function setConnection($connection) {
        $this->connection = $connection;
    }

    public function getConnection() {
        return $this->connection;
    }
}