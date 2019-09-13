<?php
$json = file_get_contents('./fuckingloader.json');

class Builder {

    function __construct($json) {
        $json_data = json_decode($json,true);
        $folders = $json_data['folders'];
        $connection = $json_data['pdo'];

        self::createAutoload($folders);
        self::createFolders($json_data['folders']);
        self::createConnFile($connection);
    }

    private function createAutoload($userFolder) {
        $autoload = fopen("autoload.php", "w") or die("Unable to open file!");
        $line = fwrite($autoload, "<?php\n");
        $line = fwrite($autoload, "spl_autoload_register(function (\$classname) {
            \$folders = " . json_encode($userFolders) . ";
            foreach(\$folders as \$folder) {
                if(file_exists(\$folder . DIRECTORY_SEPARATOR . \$classname . '.php')) {
                    require_once(\$folder . DIRECTORY_SEPARATOR . \$classname . '.php');
                }
            }
        });");
    }

    private function createFolders($userFolders) {
        foreach($userFolders as $folder) {
            if(!file_exists('./' . $folder)) {
                mkdir('./' . $folder);
            }
        }
    
        if(!file_exists('./connection')) {
            mkdir('./connection');
        }   

        if(!file_exists('./controllers')) {
            mkdir('./controllers');
        }

        if(!file_exists('./models')) {
            mkdir('./models');
        }

        if(!file_exists('./views')) {
            mkdir('./views');
        }
    }

    private function createConnFile($connection) {
        $connFile = fopen("./connection/index.php", "w") or die("Unable to open file!");
        $line = fwrite($connFile, "<?php\n");
        $line = fwrite($connFile, "
        function connect() {
            \$dsn = 'mysql:host=" . preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/','$1:',$connection['host']). ";dbname=" . $connection['dbname'] . "';
            \$user = '" . $connection['user'] . "';
            \$pass = '" . $connection['password'] . "';
            
            try{
                return new PDO(\$dsn, \$user, \$pass);
            }catch (PDOException \$e){
                // report error message
                echo \$e->getMessage();
            }
        }");
    }
}

if($json) {
    $builder = new Builder($json);   
} else {
    echo 'You must have to create the dammit file';
}