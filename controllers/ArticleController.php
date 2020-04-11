<?php

class ArticleController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function article()
    {
        $mapper = new ArticleMapper();
        $article = $mapper->getArticleById($_GET['id']);

        $this->render('article', ['topicList' => null, 'article' => $article, 'commentsExists' => null]);
    }

    public function addArticle()
    {
        if (isset($_SESSION) && !empty($_SESSION)) {
            if ($this->isPost()) {

                $mapper = new ArticleMapper();
                $newArticleId = $mapper->createNewArticle($_POST['title_name'], $_POST['content'], $_SESSION['id'], 1);
                $url = "https://$_SERVER[HTTP_HOST]/";
                header("Location: {$url}?page=article&id=" . $newArticleId);
                exit();
            } else {
                $this->render('add_article', ['topicList' => null]);
            }
        } else {
            $url = "https://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=home");
            exit();
        }
    }

    public function addTopic()
    {
        if (isset($_SESSION) && !empty($_SESSION) && $_SESSION['role'] == 'admin') {
            if ($this->isPost()) {
                $mapper = new TopicMapper();
                if ($_POST['topicName'] != null && !$mapper->topicExist($_POST['topicName'])) {
                    if ($mapper->addTopic($_POST['topicName']) != 0) {
                        $this->render('add_topic_success', ['message' => ['Dodawanie tematu zakończone pomyślnie!']]);
                        exit();
                    } else {
                        $this->render('add_topic', ['topicErrorMessage' => 'Wystąpił problem z dodawaniem tematu do bazy danych.']);
                    }

                } else {
                    $this->render('add_topic', ['topicErrorMessage' => 'Taki temat już istnieje.']);
                    exit();
                }

            }
            $this->render('add_topic');
        } else {
            $url = "https://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=home");
            exit();
        }
    }

    public function topic()
    {
        $mapper = new ArticleMapper();
        $articleList = $mapper->getArticlesByTopicId($_GET['id']);

        $topicMapper = new TopicMapper();
        $topicList = $topicMapper->getAllTopics();
        $topicName = null;
        /* @var $topic Topic */
        foreach ($topicList as $topic) {
            if ($topic->getIdTopic() == $_GET['id']) {
                $topicName = $topic->getTopic();
                break;
            }
        }
        $this->render('topic', ['articleList' => $articleList, 'topicName' => $topicName, 'topicList' => $topicList]);
    }

    public function deleteArticle()
    {

        if ($this->isPost()) {
            if (isset($_SESSION) && !empty($_SESSION)) {
                $mapper = new ArticleMapper();
                if ($_SESSION['id'] == $mapper->getArticleOwnerId($_POST['articleId']) || $_SESSION['role'] == 'admin') {
                    $mapper->deleteArticleById($_POST['articleId']);
                    $message = 'Artykuł usunięty.';
                    $status = array(
                        'error' => 0,
                        'message' => $message
                    );
                    echo json_encode($status);
                    exit();
                }
            }
        }
        $message = 'Błąd: Brak uprawnień do usunięcia.';
        $status = array(
            'error' => 1,
            'message' => $message
        );
        echo json_encode($status);
        exit();

    }

    public function deleteTopic()
    {
        if ($this->isPost()) {
            if (isset($_SESSION) && !empty($_SESSION)) {
                if ($_SESSION['role'] == 'admin') {
                    $articleMapper = new ArticleMapper();
                    if ($articleMapper->deleteTopicById($_POST['topicId'])) {
                        $message = 'Artykuł usunięty.';
                        $status = array(
                            'error' => 0,
                            'message' => $message
                        );
                    } else {
                        $message = 'Wystąpił problem przy usuwaniu.';
                        $status = array(
                            'error' => 1,
                            'message' => $message
                        );
                    }
                    echo json_encode($status);
                    exit();
                }
            }
            $message = 'Błąd: Brak uprawnień do usunięcia.';
            $status = array(
                'error' => 1,
                'message' => $message
            );
            echo json_encode($status);
            exit();
        }
    }

    public function modifyArticle()
    {
        if (isset($_SESSION) && !empty($_SESSION)) {
            $articleMapper = new ArticleMapper();
            if ($_SESSION['id'] == $articleMapper->getArticleOwnerId($_GET['id']) || $_SESSION['role'] == 'admin') {
                if ($this->isPost()) {
                    $articleMapper->modifyArticle($_POST['title_name'], $_POST['content'], $_POST['id_topic'], $_GET['id']);
                    $url = "https://$_SERVER[HTTP_HOST]/";
                    header("Location: {$url}?page=article&id=" . $_GET['id']);
                    exit();
                } else {
                    $article = $articleMapper->getArticleById($_GET['id']);
                    $this->render('modify_article', ['topicList' => null, 'article' => $article]);
                    exit();
                }
            }
        }
        $url = "https://$_SERVER[HTTP_HOST]/";
        header("Location: {$url}?page=article&id=" . $_GET['id']);
        exit();
    }
}