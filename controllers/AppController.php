<?php

require_once __DIR__ . '/../session/SessionDBHandler.php';

class AppController
{
    const UPLOAD_DIRECTORY = '/public/upload/';

    private $request = null;
    private $sessionHandler;

    public function __construct()
    {
        $this->request = strtolower($_SERVER['REQUEST_METHOD']);
        $this->sessionHandler = new SessionDBHandler();

    }

    public function isGet()
    {
        return $this->request === 'get';
    }

    public function isPost()
    {
        return $this->request === 'post';
    }

    public function render(string $fileName = null, $variables = [])
    {
        $view = $fileName ? dirname(__DIR__) . '/views/' . get_class($this) . '/' . $fileName . '.php' : '';

        $output = 'There isn\'t such file to open';

        if (file_exists($view)) {

            extract($variables);

            ob_start();
            include $view;
            $output = ob_get_clean();
        }

        print $output;
    }
}