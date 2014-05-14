<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 1/13/14
 * Time: 7:59 PM
 */
//a class to help work with Sessions

class Session
{

    private $logged_in = false;
    public $user_id;
    public $message;

    function __construct()
    {
        session_start();
        $this->check_login();
        $this->check_message();
        if ($this->logged_in) {
            // actions to take right away if user is logged in
        } else {
            // actions to take right away if user is not logged in
        }
    }

    public function message($msg = "")
    {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function is_logged_in()
    {
        return $this->logged_in;
    }

    public function login($user)
    {
        // database should find user based on username/password
        if ($user) {
            $this->strong_id = $_SESSION['strong_id'] = session_id() .
                $_SERVER['HTTP_USER_AGENT'] .
                $_SERVER['REMOTE_ADDR'] .
                "totalperspectivevortex";

            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->user_name = $_SESSION['user_name'] = $user->username;
            $this->first_name = $_SESSION['first_name'] = $user->first_name;
            $this->logged_in = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($this->user_id);
        unset($this->user_name);
        session_destroy();
        $this->logged_in = false;
    }

    private function  check_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    private function check_message()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}

$session = new Session ();
$message = $session->message();
?>