<?php

class Utils_Login {
    public static function register_session($user): void {
        $_SESSION["user"] = $user;
        $_SESSION["logged_in"] = $user->id !== null;
        $_SESSION["is_admin"] = (int)$user->is_admin;
    }

    static function delete_session(){
        unset($_SESSION['user']);
    }

    static function check_session_or_error(): void{
        if(!isset($_SESSION['user'])){
            throw new Exceptions_Unauthorized("Unauthorized");
        }
    }

    public static function is_admin():bool{
        return $_SESSION['is_admin'];
    }

    public static function is_logged_in():bool{
        return $_SESSION['logged_in'];
    }


}