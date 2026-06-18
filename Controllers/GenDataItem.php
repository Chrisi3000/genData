<?php

require_once "Base.php";

class Controllers_GenDataItem extends Controllers_Base {
    public function get(){
        $this->view->render("Hello world");
    }
}