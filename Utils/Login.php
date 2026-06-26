<?php

class Utils_Login {

    public static function register_session($user): void {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["username"] = $user->username;
        $_SESSION["is_admin"] = $user->is_admin;
    }

    public static function register_guest(): void {
        $user = new Domains_User([
            "id" => null,
            "username" => "guest",
            "password" => null,
            "is_admin" => 0
        ]);

        self::register_session($user);
    }

    public static function delete_session(): void {
        unset($_SESSION["user_id"]);
        unset($_SESSION["username"]);
        unset($_SESSION["is_admin"]);
    }

    public static function check_session_or_error(): void {
        if (!self::is_logged_in()) {
            throw new Exceptions_Unauthorized("Unauthorized");
        }
    }

    public static function is_admin(): bool {
        return !empty($_SESSION["is_admin"]);
    }

    public static function is_logged_in(): bool {
        return !empty($_SESSION["user_id"]);
    }

    public static function get_user_id(): ?int {
        return $_SESSION["user_id"] ?? null;
    }

    public static function get_username(): ?string {
        return $_SESSION["username"] ?? null;
    }
}