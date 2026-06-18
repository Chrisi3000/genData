<?php

require_once __DIR__ . "/../Controllers/GenDataItem.php";
require_once __DIR__ . "/../Views/Html.php";

class Utils_Dispatcher
{
    public function dispatch() {
        $url_elements = explode("/", $_SERVER['PATH_INFO']);
        $resource_type = $url_elements[1];
        $path_params = array_filter(array_slice($url_elements, 2));

        try {
            if($resource_type === "genDataItem"){
                $view = new Views_Html($resource_type, $path_params);
                $controller = new Controllers_GenDataItem($view, $path_params);
                $controller->get();
            }
        } catch (Throwable $e){
            echo "error occured:" ;
            echo $e->getMessage();
        }

    }
}