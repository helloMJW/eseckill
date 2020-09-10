<?php


namespace App\HttpController\Api\User;


use App\HttpController\Api\AuthBase;
use App\Model\User\UsersModel;
use EasySwoole\Validate\Validate;
use EasySwoole\Jwt\Jwt;

class User extends AuthBase
{
    public function info()
    {
        $userModel = new UsersModel();
        $info = $userModel->getInfoByUid($this->uid);
        $this->writeJson(1, $info, 'ok');
    }

    protected function validateRule(?string $action): ?Validate
    {
        $v = new Validate();
        switch ($action){
            case 'info':{
                break;
            }
        }
        return $v;
    }
}