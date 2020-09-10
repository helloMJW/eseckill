<?php


namespace App\HttpController;

use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\HttpAnnotation\AnnotationController;
use EasySwoole\Validate\Validate;

class BaseController extends AnnotationController
{
    protected function input($name, $default = null) {
        $value = $this->request()->getRequestParam($name);
        return $value ?? $default;
    }

    protected function validateRule(?string $action):?Validate
    {

    }

    protected function validate(Validate $validate)
    {
        $rawJson = $this->request()->getBody()->__toString();
        if($rawJson) {
            $this->input = json_decode($rawJson, true);
        } else {
            $this->input = [];
        }
        return $validate->validate($this->input);
    }
}