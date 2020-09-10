<?php

namespace App\HttpController\Api;


use App\HttpController\Api\ApiBase;
use App\Model\User\UsersModel;
use EasySwoole\Log\Logger;
use EasySwoole\Validate\Validate;
use EasySwoole\Utility\Hash;

class Register extends ApiBase
{
    /**
     * 用户注册
     */
    public function user()
    {
        $this->input ['password'] = Hash::makePasswordHash($this->input ['password']);
        try{
            $usersModel = new UsersModel();
            $usersModel->storage($this->input);
        } catch (\Exception $e) {
            Logger::getInstance()->waring('>>>>>>>>>>^_^>>>>> register/user: ' . $e->getMessage());
        }
        $this->writeJson(200, null, '注册成功');
    }

    protected function validateRule(?string $action): ?Validate
    {
        $v = new Validate();
        switch ($action){
            case 'user':{
                $v->addColumn('email','邮箱')->required('不能为空');
                $v->addColumn('password','密码')->required('不能为空')->lengthMin(6,'长度错误');
                break;
            }
        }
        return $v;
    }
}