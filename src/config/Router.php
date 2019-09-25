<?php
class Router {
        private $routes = [];
        public function get($route, $action = '::') {
            if(gettype($action) === 'string') {
                self::executeGetController($route, $action);  
            }
        }
        

        public function run() {
            $url = '/'.$_GET['url'];
            $urlArray = explode('/', $url);
            $arr = [];
    
            if(array_key_exists($url, $this->routes)) {
                self::invocateFunction($this->routes[$url]);
            } else {
                $replacedRoute = '';
                $found = false;
    
                foreach ($this->routes as $route => $key) {
                    $routeArray = explode('/', $route);
                    $params = [];
                    
                    $matchRoute = self::searchAndGetParamsFromMatchRoute($routeArray, $urlArray, $route, $url);
                    $replacedRoute = $matchRoute['replacedRoute'];
                    $params = $matchRoute['params'];
    
                    if($replacedRoute === $route) { 
                        $found = true;
                        break;
                    }
                }
    
                if($found === true) {
                    self::invocateFunction($this->routes[$route], $params);
                }
            }
            

            private function searchAndGetParamsFromMatchRoute($routeArray, $urlArray, $route, $url) {
                $replacedRoute = '';
                $params = [];
        
                for($i = 0; $i < count($routeArray); $i++){
                    if((strpos($routeArray[$i], ':') !== false) && (count($urlArray) == count($routeArray))){
                        $index = str_replace(':', '', $routeArray[$i]);
        
                        $routeArray[$i] = $urlArray[$i];
                        $params[$index] = $\urlArray[$i];
        
                        $explodedRoute = explode('/', $route);
                        $replacedRoute = preg_replace('/^\/'.$explodedRoute[1].'\/([^;]*)$/i', $route, $url);
                    }
                    $route[0] = implode($routeArray, '/');
                }
        
                return ['replacedRoute' => $replacedRoute, 'params' => $params];
            }
            

            private function invocateFunction($route, $params = []) {
                $controller = $route['controller'];
                $method = $route['method'];
                require(__DIR__ . '/controllers/' . $controller . '.php');
                $controller = new $controller();
                print_r($controller->$method($params));
            }
            

            private function executeGetController($route, $action) {
                if($action !== '::') {
                    $action = explode('::', $action);
                    $controller = $action[0];
                    $method = $action[1];
        
                    $folderExists = $this->verifyFolderExists();
                    if(!$folderExists) {
                        return 'You must have the controllers folder!';
                    }
        
                    $fileExists = $this->verifyFileExists($controller);
                    if(!$fileExists) {
                        return 'You must have ' . $controller . ' controller file!';
                    }
        
                    $this->routes[$route] = array('controller' => $controller, 'method' => $method);
                }
            }
            

            private function verifyRoute($route) {
                $r = explode('/', $route);
                $params = explode('/', $_GET['url']);
                $parts = parse_url($_GET['url']);
                var_dump($parts);
        
                if($route == '/'.$_GET['url']) {
                    return true;
                }
        
                return false;
            }
            

            private function verifyFolderExists() {
                if(!file_exists(__DIR__ . '/controllers')) {
                    return false;
                }
                
                return true;
            }
            

            private function verifyFileExists($file) {
                if(!file_exists(__DIR__ . '/controllers/' . $file . '.php')) {
                    return false;
                }
                
                return true;
            }
            }
        