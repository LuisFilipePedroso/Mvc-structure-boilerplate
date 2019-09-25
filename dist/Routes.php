<?php

class CreateRoutes {

    private $name;
    private $controller;
    private $method;
    private $file;

    public function __construct($path) {
        $this->file = fopen("./src/routes.php", "w") or die("Unable to open file!");
        $line = fwrite($this->file, "<?php\n");
        $line = fwrite($this->file, "require('./Router.php');\n");
        $line = fwrite($this->file, "\$router = new Router();\n");
    }

    public function addToFile() {
        $line = fwrite($this->file, "\$router->get('".$this->name."', '". $this->controller ."::". $this->method . "');\n");
    }

    public function finishFile() {
        $line = fwrite($this->file, "\$router->run();");
        fclose($this->file);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getController() {
        return $this->controller;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }
}