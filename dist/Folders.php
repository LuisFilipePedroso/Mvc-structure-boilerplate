<?php

class Folders {

    private $userFolders;

    public function createFolders() {
        if(!file_exists('./src')) {
            mkdir('./src');
        }   

        foreach($this->userFolders as $folder) {
            if(!file_exists('./src/' . $folder)) {
                mkdir('./src/' . $folder);
            }
        }
    
        if(!file_exists('./src/connection')) {
            mkdir('./src/connection');
        }   

        if(!file_exists('./src/controllers')) {
            mkdir('./src/controllers');
        }

        if(!file_exists('./src/config')) {
            mkdir('./src/config');
        } 

        if(!file_exists('./src/models')) {
            mkdir('./src/models');
        }

        if(!file_exists('./src/views')) {
            mkdir('./src/views');
        }
    }

    public function setUserFolders($userFolders) {
        $this->userFolders = $userFolders;
    }

    public function getUserFolders() {
        return $this->userFolders;
    }
}
