<?php

class Controllers_Login extends Controllers_Base {
    private Models_User $model;

    // initializes core user data model layers onto the login controller instance
    public function __construct(Views_Base $views, array $params) {
        parent::__construct($views, $params);
        $this->model = new Models_User();
    }

    // serves the standard user authentication form viewport to the browser
    public function get() {
        $data = "login";
        $this->view->render($data);
    }

    // processes incoming login submissions or delegates execution to guest routines
    public function post(){
        // intercepts action payload flags to branch out into guest access pipelines
        if($_POST["action"] == "guest") {
            $this->guest();
            exit();
        }

        $input_username = $_POST["username"] ?? null;
        $input_password = $_POST["password"] ?? null;

        // validates existence of both identifier strings before proceeding
        if($input_username == null || $input_password == null){
            $_SESSION["login_error"] = "Username or password is not entered.";
            header("Location: /geneData/Login");
            exit();
        }

        $username = $input_username;
        $pw = $input_password;

        // verifies credential matches using internal model validation processes
        $user = $this->model->login($username, $pw);
        if($user == null){
            $_SESSION["login_error"] = "Username or password is incorrect.";
            header("Location: /geneData/Login");
            exit();
        }

        // establishes authorized identity tracks in native session parameters
        Utils_Login::register_session($user);
        header("Location: /geneData/GeneDataItem");
        die();
    }

    // provisions restricted non-authenticated proxy profile spaces for quick entry
    public function guest() {
        Utils_Login::register_guest();

        header("Location: /geneData/GeneDataItem");
        exit();
    }

    // directly assesses legacy raw multidimensional arrays to check administrative rank flags
    public static function is_admin(): bool {
        return isset($_SESSION['user']['is_admin'])
            && $_SESSION['user']['is_admin'] == 1;
    }
}