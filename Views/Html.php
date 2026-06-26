<?php

require_once "Base.php";

class Views_Html extends Views_Base
{
    public function render($data)
    {
        // Determines standard view templates based on the structure of incoming payload data
        if (is_array($data)) {
            $template = "table.phtml"; // Arrays default to collection list grids
        }
        else if($data === "login"){
            $template = "login.phtml";
        }
        else if($data === "register"){
            $template = "register.phtml";
        }
        else{
            $template = "object.phtml"; // Individual objects default to singular detail views
        }

        // Inspects the raw inbound URL path to match special CRUD form interaction endpoints
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $trimmedPath = rtrim($path, '/'); // Sanitizes trailing slashes to secure string matches

        // Forces creation form layout if endpoint explicitly points to action trailing sequence
        if (str_ends_with($trimmedPath, '/create')) {
            $template = "create.phtml";
        }
        // Intercepts modification requests to mount updating interfaces
        else if (str_contains($trimmedPath, '/edit/') || str_ends_with($trimmedPath, '/edit')) {
            $template = "edit.phtml";
        }

        // Checks if a modular subfolder version of the targeted template exists
        if (is_readable(dirname(__FILE__) . "/templates/" . $this->resource_name . "/" . $template)) {
            $template = $this->resource_name . "/" . $template;
        }


        // Overrides any layout choices instantly if the system pipeline passed an execution Failure object
        if($data instanceof Exception){
            $template = "error.phtml";
        }

        // Includes the resolved presentation layout fragment and terminates the runtime to isolate response output
        include "templates/" . $template;
        exit;
    }
}