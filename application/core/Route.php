<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:28
 */

namespace Core;

class Route
{
    static function start()
    {
        // Controller and Action by default
        $controllerName = 'user';
        $actionName = 'index';

        if(isset($_GET['route'])) {
            $routes = explode('/', $_GET['route']);

            // getting controller name
            if (!empty($routes[0])) {
                $controllerName = $routes[0];
            }

            // getting action name
            if (!empty($routes[1])) {
                $actionName = $routes[1];
            }
        }

        $controllerName = 'Controller' . ucfirst($controllerName);
        $actionName = 'action' . ucfirst($actionName);
        $controllerPath = 'application/controllers/' . $controllerName . '.php';
        $controllerName = '\Controllers\\' . $controllerName;

        if(file_exists($controllerPath)) {
            $controller = new $controllerName(new View(), new EmailManager());
        } else {
            Route::ErrorPage404();
        }

        if (method_exists($controller, $actionName)) {
            $controller->$actionName();    
        } else {
            Route::ErrorPage404();
        }
    }

    static function ErrorPage404()
    {
        $config = @parse_ini_file(__DIR__ . '/../../config.ini', true);

        if (!$config) {
            throw new \Exception("Config file parsing error!");
        }

        return header(sprintf("Location: %s", $config['route']['404']));
    }
}