<?php

class Utils_Dispatcher
{
    public function dispatch()
    {
        $url_elements = explode('/', $_SERVER['PATH_INFO']);
        $resource_type = $url_elements[1];

        $path_params = array_slice($url_elements, 2);

        $view_type = "Json";
        if (isset($_SERVER["HTTP_ACCEPT"])) {
            $view_type = str_contains( strtolower($_SERVER["HTTP_ACCEPT"]), "application/json") ? "Json" : "Html";
        }
        $view_type = "Views_" . $view_type;

        $view = new $view_type($resource_type, $path_params);

        try {
            $controller_name = "Controllers_" . $resource_type;
            $controller_instance = new $controller_name($view, $path_params);

            $verb = strtolower($_SERVER['REQUEST_METHOD']);

            if ($verb === "put") {
                 parse_str(file_get_contents("php://input"),$GLOBALS["_PUT"]);
            }

            $controller_instance->$verb();

        } catch (Exception $e) {
            $controller = new Controllers_Error($view, $path_params);
            $controller->error($e);
        }
    }
}