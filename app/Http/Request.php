<?php

namespace App\Http;

class Request
{
    protected array $segments = [];
    protected string $controller;
    protected string $method;

    public function __construct()
    {
        $this->segments = explode('/', $_SERVER['REQUEST_URI']);
        $this->setController();
        $this->setMethod();
    }

    public function setController(): void
    {
        $this->controller = empty($this->segments[1])
            ? 'home'
            : $this->segments[1];
    }

    public function getController(): string
    {
        $controller = ucfirst($this->controller);
        return "App\Http\Controllers\\{$controller}Controller";
    }

    public function setMethod(): void
    {
        $this->method = empty($this->segments[2])
            ? 'index'
            : $this->segments[2];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function send(): void
    {
        $controller = $this->getController();
        $method = $this->getMethod();

        $response = call_user_func([new $controller, $method]);
        $response->send();

        try {
            if ($response instanceof Response) {
                $response->send();
            } else {
                throw new \Exception("Error Processing Request");
            }
        } catch (\Exception $e) {
            echo "Details {$e->getMessage()}";
        }
    }

}