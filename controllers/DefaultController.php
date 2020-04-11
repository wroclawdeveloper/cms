<?php

require_once "AppController.php";
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/UserMapper.php';
require_once __DIR__ . '/../model/Article.php';
require_once __DIR__ . '/../model/ArticleMapper.php';


class DefaultController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $articleMapper = new ArticleMapper();

        $articleList = $articleMapper->getAllArticles();

        $this->render('home', ['articleList' => $articleList, 'topicList' => null]);
    }
}