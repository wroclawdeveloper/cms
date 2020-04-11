<?php

require_once('controllers/DefaultController.php');
require_once('controllers/ArticleController.php');
require_once('controllers/LoginController.php');
require_once('controllers/AdminController.php');

class Routing
{
    public $routes = [];

    public function __construct()
    {
        $this->routes = [
            'home' => [
                'controller' => 'DefaultController',
                'action' => 'home'
            ],
            'login' => [
                'controller' => 'LoginController',
                'action' => 'login'
            ],
            'logout' => [
                'controller' => 'LoginController',
                'action' => 'logout'
            ],
            'register' => [
                'controller' => 'LoginController',
                'action' => 'register'
            ],
            'article' => [
                'controller' => 'ArticleController',
                'action' => 'article'
            ],
            'add_article' => [
                'controller' => 'ArticleController',
                'action' => 'addArticle'
            ],
            'admin' => [
                'controller' => 'AdminController',
                'action' => 'index'
            ],
            'admin_users' => [
                'controller' => 'AdminController',
                'action' => 'users'
            ],
            'admin_delete_user' => [
                'controller' => 'AdminController',
                'action' => 'userDelete'
            ],
            'delete_article' => [
                'controller' => 'ArticleController',
                'action' => 'deleteArticle'
            ],
            'modify_article' => [
                'controller' => 'ArticleController',
                'action' => 'modifyArticle'
            ]
        ];
    }

    public function run()
    {
        $page = isset($_GET['page'])
        && isset($this->routes[$_GET['page']]) ? $_GET['page'] : 'home';

        if ($this->routes[$page]) {
            $class = $this->routes[$page]['controller'];
            $action = $this->routes[$page]['action'];

            $object = new $class;
            $object->$action();
        }
    }

}