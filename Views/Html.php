<?php

require_once "Base.php";

class Views_Html extends Views_Base
{

    public function render($data)
    {
        $template = "object.phtml";
        include "templates/" . $template;
        exit;
    }
}