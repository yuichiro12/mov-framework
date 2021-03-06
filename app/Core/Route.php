<?php
namespace app\Core;

class Route
{
    private $param;

    public function run() {
        $route = $this->getRoute();
        $prefix = 'app\Controller\\';
        $ctrlname = $prefix . ucfirst($route['controller']) . 'Controller';
        $action = $route['action'];
        $controller = new $ctrlname();

        return $controller->{$action}($this->param);
    }

    private function getRoute() {
        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch (true) {
            // [example]
            // case $this->match('/posts/edit/:id'):
            //     return ['controller' => 'posts', 'action' => 'edit'];
            default:
                throw new NotFoundException;
            }
            break;
        case 'POST':
            switch (true) {
            // [example]
            // case $this->match('/posts/update/:id'):
            //     return ['controller' => 'posts', 'action' => 'update'];
            default:
                throw new NotFoundException;
            }
            break;
        }
    }

    private function match($pattern) {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $patterns = explode('/', $pattern);
        $paths = explode('/', $path);
        foreach($patterns as $i => $v) {
            if (isset($paths[$i]) && ($v === $paths[$i])) {
                continue;
            } elseif ((strpos($v, ':') === 0) && is_numeric($paths[$i])) {
                $this->param = $paths[$i];
                continue;
            }
            $this->param = null;
            return false;
        }
        return true;
    }
}
