<?php

require_once "AppController.php";

class LoginController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $mapper = new UserMapper();

        $user = null;

        if ($this->isPost()) {

            $user = $mapper->getUser($_POST['login']);
            if (empty($user->getIdUser())) {
                $this->render('login', ['loginErrorMessage' => 'Nieznany login']);
                exit();
            }

            if (!password_verify($_POST['password'], $user->getPassword())) {
                $this->render('login', ['passwordErrorMessage' => 'Niepoprawne hasło']);
                exit();
            } else {
                $_SESSION["id"] = $user->getIdUser();
                $_SESSION["role"] = 'admin';

                $url = "https://$_SERVER[HTTP_HOST]/";
                header("Location: {$url}?page=home");
                exit();
            }
        }

        if (isset($_SESSION) && !empty($_SESSION)) {
            $url = "https://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=home");
            exit();
        }
        $this->render('login');
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        $this->render('logout', ['message' => ['Pomyślnie wylogowano!']]);
    }

    public function register()
    {
        if ($this->isPost()) {
            $mapper = new UserMapper();
            $emailErrorMessage = null;
            $loginErrorMessage = null;
            $passwordErrorMessage = null;

            if ($mapper->emailExist($_POST['email'])) {
                $emailErrorMessage = 'Podany email jest już zajęty';
            }
            if ($mapper->loginExist($_POST['login'])) {
                $loginErrorMessage = 'Podany login jest już zajęty';
            }
            if ($_POST['password'] != $_POST['password-confirmation']) {
                $passwordErrorMessage = 'Podane hasła nie są identyczne';
            }
            if ($emailErrorMessage != null || $loginErrorMessage != null || $passwordErrorMessage != null) {
                $this->render('register', ['emailErrorMessage' => $emailErrorMessage, 'loginErrorMessage' => $loginErrorMessage, 'passwordErrorMessage' => $passwordErrorMessage]);
                exit();
            }
            $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $mapper->createUser($_POST['login'], $_POST['email'], $hash);

            $user = $mapper->getUser($_POST['login']);
            $_SESSION["id"] = $user->getIdUser();
            $_SESSION["role"] = $user->getRole()->getRole();

            $this->render('successful_registration', ['message' => ['Rejestracja zakończona pomyślnie!']]);
            exit();
        }
        $this->render('register');
    }
}