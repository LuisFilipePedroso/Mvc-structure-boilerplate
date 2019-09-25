<?php
require('dist/Autoload.php');
require('dist/ConnFile.php');
require('dist/Folders.php');
require('dist/Router.php');
require('dist/Routes.php');

$json = file_get_contents('./loader.json');

class Builder {

    function __construct($json) {
        $json_data = json_decode($json,true);
        $folders = $json_data['folders'];
        $connection = $json_data['pdo'];
        $routes = $json_data['routes'];

        self::createFolders($folders);
        self::createRouterClass();
        
        self::createAutoload($folders);
        self::createConnFile($connection);

        self::createRoutes($routes);
    }

    private function createFolders($userFolders) {
        $folders = new Folders();
        $folders->setUserFolders($userFolders);
        $folders->createFolders();
    }

    private function createRouterClass() {
        $router = new CreateRouter();
        $router->generateRouterClass("./src/config", "Router");
    }

    private function createAutoload($userFolder) {
        $autoload = new Autoload();
        $folders = ['connection', 'controllers', 'config', 'models', 'views'];

        foreach($userFolder as $folder) {
            array_push($folders, $folder);
        }

        $autoload->setUserFolders($folders);
        $autoload->createAutoload();
    }

    private function createConnFile($connection) {
        $connFile = new ConnFile();
        $connFile->setConnection($connection);
        $connFile->createConnFile();
    }

    private function createRoutes($routes) {
        $routeFile = new CreateRoutes('./config');
        foreach($routes as $route) {
            $routeFile->setName($route['name']);
            $routeFile->setController($route['controller']);
            $routeFile->setMethod($route['method']);
            $routeFile->addToFile();
        }
        $routeFile->finishFile();
    }
}

if($json) {
    $builder = new Builder($json);   
} else {
    echo 'You must have to create the dammit file';
}