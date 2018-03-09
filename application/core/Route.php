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

    function ErrorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: index.php?route=404');
    }
}