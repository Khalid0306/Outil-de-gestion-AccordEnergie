<?php
namespace App;

class Session {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add(string $key, array $data) {
        $_SESSION[$key] = $data;
    }

    public function get(string $key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function isConnected() {
        return isset($_SESSION['user']);
    }

    public function asRole(string $role) {

        return isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] == $role;

    }


   

    
    public function destroy() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
