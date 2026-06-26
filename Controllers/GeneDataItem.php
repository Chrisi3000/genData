<?php

require_once "Base.php";

class Controllers_GeneDataItem extends Controllers_Base {
    private $model;

    // hooks resource-specific domain data persistency layers to the execution scope
    public function __construct(Views_Base $view, array $params) {
        parent::__construct($view, $params);
        $this->model = new Models_GeneDataItem();
    }

    // handles collection fetch queries or targets a single row based on parameter parameters
    public function get(){
        if($this->params){
            $data = $this->model->findById($this->params[0]);
        } else{
            $data = $this->model->findAll();
        }

        $this->view->render($data);
    }

    // reads support datasets to provide structured selectable collection choices down to views
    public function create()
    {
        $organismModel = new Models_Organism();
        $organisms = $organismModel->findAll();

        $this->view->render($organisms);
    }

    // processes creation submissions, merges default parameters, and redirects to resource indices
    public function post()
    {
        if (!Utils_Login::is_logged_in()) {
            throw new Exceptions_Unauthorized("Unauthorized");
        }

        $data = $_POST;

        $data["reviewed"] = isset($data["reviewed"]) ? 1 : 0;
        $data["created_by"] = $_SESSION["user_id"];

        $obj = new Domains_GeneDataItem($data);
        $result = $this->model->insert($obj);

        header("Location: /geneData/GeneDataItem/" . $result->id);
        exit();
    }

    public function put()
    {
        $this->executeUpdate();
    }

    public function edit()
    {
        if (!Utils_Login::is_logged_in()) {
            throw new Exceptions_Unauthorized("Unauthorized");
        }

        if (!isset($this->params[0])) {
            throw new Exception("Id not found");
        }

        // if the client sends a put request, handle data processing instantly
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->executeUpdate();
        }

        // default get route: fetch data and render template view
        $this->view->render([
            'gene' => $this->model->findById($this->params[0]),
            'organisms' => (new Models_Organism())->findAll()
        ]);
    }

    // private helper to handle payload decoding and model database execution
    private function executeUpdate()
    {
        if (!Utils_Login::is_logged_in()) {
            exit(json_encode(["error" => "Unauthorized"], http_response_code(401)));
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $input["id"] ??= $this->params[0] ?? null;

        if (!$input["id"]) {
            exit(json_encode(["error" => "Id not found"], http_response_code(400)));
        }

        // normalize boolean or string flags into strict database integers
        $input["reviewed"] = !empty($input["reviewed"]) && ($input["reviewed"] === true || $input["reviewed"] == "1") ? 1 : 0;
        $_POST = $input;

        try {
            $this->model->update(new Domains_GeneDataItem($input));
            exit(json_encode(["success" => true]));
        } catch (Exception $e) {
            http_response_code(500);
            exit(json_encode(["error" => $e->getMessage()]));
        }
    }

    // purges designated row parameters directly from database structures using core id elements
    public function delete() {
        if(!Utils_Login::is_logged_in()){
            throw new Exceptions_Unauthorized("Unauthorized");
        }

        if(!isset($this->params[0])){
            throw new Exception("Id not found");
        }

        $this->model->delete($this->params[0]);
        http_response_code(204);
    }
}