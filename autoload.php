<?php
spl_autoload_register(function ($classname) {
            $folders = null;
            foreach($folders as $folder) {
                if(file_exists($folder . DIRECTORY_SEPARATOR . $classname . '.php')) {
                    require_once($folder . DIRECTORY_SEPARATOR . $classname . '.php');
                }
            }
        });