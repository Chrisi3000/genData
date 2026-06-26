<?php

class Controllers_Register extends Controllers_Base {
    private Models_User $model;

    // mounts corresponding user data persistency layers onto the system instance context
    public function __construct(Views_Base $views, array $params) {
        parent::__construct($views, $params);
        $this->model = new Models_User();
    }

    // serves standard registration form layouts down to the client interface layer
    public function get() {
        $data = "register";
        $this->view->render($data);
    }

    // handles creation payloads, validates identity overlaps, hashes text credentials, and boots standard login sessions
    public function post(){
        $username = $_POST["username"];
        $pw = $_POST["password"];
        // transforms raw user text into secure password hashes before storage
        $hash_password = password_hash($pw, PASSWORD_DEFAULT);

        // checks unique namespace constraints to block duplicate profile indexing paths
        if ($this->model->findByUsername($username) != null) {
            $_SESSION["register_error"] = "User already exists.";
            header("Location: /geneData/Register");
            exit();
        }

        $this->model->createUser($username, $hash_password);

        $user = $this->model->login($username, $pw);

        // establishes localized server side authorization context for the new profile entry
        Utils_Login::register_session($user);
        header("Location: /geneData/Login");
        die();
    }
}