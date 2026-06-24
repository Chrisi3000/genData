<?php

require_once __DIR__ . "/../Controllers/GeneDataItem.php";
require_once __DIR__ . "/../Views/Html.php";

class Utils_Dispatcher
{
    public function dispatch() {

        $url_elements = explode("/", $_SERVER['PATH_INFO']);
        $resource_type = $url_elements[1];
        $path_params = array_filter(array_slice($url_elements, 2));

        $view = new Views_Html($resource_type, $path_params);

        try {

            $controller_name = "Controllers_" . $resource_type;
            $controller = new $controller_name($view, $path_params);

            $verb = strtolower($_SERVER['REQUEST_METHOD']);

            if ($verb === "post" && isset($_POST['_method'])) {

                $override = strtolower($_POST['_method']);

                if (in_array($override, ['put', 'delete'])) {
                    $verb = $override;
                }
            }

            if ($verb === "put") {
                parse_str(file_get_contents("php://input"), $GLOBALS["_PUT"]);
            }

            if ($verb === "delete") {
                parse_str(file_get_contents("php://input"), $GLOBALS["_DELETE"]);
            }


            if (!method_exists($controller, $verb)) {
                throw new Exception("Method not allowed: " . $verb);
            }

            $controller->$verb();

        } catch (Throwable $e){
            echo "error occurred: ";
            echo $e->getMessage();
        }
    }
}