<?php

class Controllers_Logout extends Controllers_Base {
    // executes profile disconnect routine by purging active authentication sessions and redirecting to login portal
    public function get(){
        Utils_Login::delete_session();
        header("Location: /geneData/Login");
        die();
    }
}