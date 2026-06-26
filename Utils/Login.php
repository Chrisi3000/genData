<?php

class Utils_Login {

    // populates native session arrays with properties of an authenticated user
    public static function register_session($user): void {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["username"] = $user->username;
        $_SESSION["is_admin"] = $user->is_admin;
    }

    // instantiates an unauthenticated fallback entity to secure system context metrics
    public static function register_guest(): void {
        $user = new Domains_User([
            "id" => null,
            "username" => "guest",
            "password" => null,
            "is_admin" => 0
        ]);

        self::register_session($user);
    }

    // clears precise identity footprints out of current active session scopes
    public static function delete_session(): void {
        unset($_SESSION["user_id"]);
        unset($_SESSION["username"]);
        unset($_SESSION["is_admin"]);
    }

    // throws a guard exception to disrupt code execution if security parameters fail
    public static function check_session_or_error(): void {
        if (!self::is_logged_in()) {
            throw new Exceptions_Unauthorized("Unauthorized");
        }
    }

    // evaluates flag values to check if the current user possesses administrative rights
    public static function is_admin(): bool {
        return !empty($_SESSION["is_admin"]);
    }

    // confirms if a non-zero identity identifier key is actively stored in the session
    public static function is_logged_in(): bool {
        return !empty($_SESSION["user_id"]);
    }

    // retrieves the current primary identification marker or returns null
    public static function get_user_id(): ?int {
        return $_SESSION["user_id"] ?? null;
    }

    // returns the active textual name identifier string bound to the user
    // not directly needed, but good to have
    public static function get_username(): ?string {
        return $_SESSION["username"] ?? null;
    }
}