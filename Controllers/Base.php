<?php

abstract class Controllers_Base {
    protected array $params;
    protected Views_Base $view;

    // saves foundational layout engine states and explicit routing parameter matrix blocks
    public function __construct(Views_Base $view, array $params){
        $this->params = $params;
        $this->view = $view;
    }
}