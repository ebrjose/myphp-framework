<?php

namespace App\Http;

class Response
{
    protected string $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function send()
    {
        $view = $this->getView();

        $content = file_get_contents(viewPath($view));

        require viewPath('layout');
    }

}