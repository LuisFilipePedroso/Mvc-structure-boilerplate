<?php

class Autoload {

    private $userFolders;
    
    public function createAutoLoad() {
        $autoload = fopen("./src/autoload.php", "w") or die("Unable to open file!");
        $line = fwrite($autoload, "<?php\n");
        $line = fwrite($autoload, "spl_autoload_register(function (\$classname) {
            \$folders = " . json_encode($this->userFolders) . ";
            foreach(\$folders as \$folder) {
                if(file_exists(\$folder . DIRECTORY_SEPARATOR . \$classname . '.php')) {
                    require_once(\$folder . DIRECTORY_SEPARATOR . \$classname . '.php');
                }
            }
        });");
    }

    public function setUserFolders($userFolders) {
        $this->userFolders = $userFolders;
    }

    public function getUserFolders() {
        return $this->userFolders;
    }
}