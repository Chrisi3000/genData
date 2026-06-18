<?php

require_once "Base.php";

class Controllers_GeneDataItem extends Controllers_Base {
    private $model;

    public function __construct(Views_Base $view, array $params) {
        parent::__construct($view, $params);
        $this->model = new Models_GeneDataItem();
    }

    public function get(){
        if($this->params){
            $data = $this->model->findById($this->params[0]);
        } else{
            $data = $this->model->findAll();
        }

        $this->view->render($data);
    }

}