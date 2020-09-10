<?php


namespace App\HttpController\Api;
use App\Model\User\UsersModel;
use EasySwoole\Jwt\Jwt;
use EasySwoole\Utility\Hash;
use EasySwoole\Validate\Validate;

/**
 * 用户登录
 * Class Login
 * @package App\HttpController\Api
 */
class Login extends ApiBase
{

    public function user()
    {

        $usersModel = new UsersModel();
        $email = $this->input['email'];
        $user = $usersModel->login($email);

        if(!Hash::validatePasswordHash($this->input['password'], $user->password)) {
            $this->writeJson(4000, null, '密码错误');
            return false;
        }

        $jwtObject = Jwt::getInstance()
            ->setSecretKey('eseckill') // 秘钥
            ->publish();

        $jwtObject->setAlg('HMACSHA256'); // 加密方式
        $jwtObject->setAud($email); // 用户
        $jwtObject->setExp(time()+3600); // 过期时间
        $jwtObject->setIat(time()); // 发布时间
        $jwtObject->setIss('eseckill'); // 发行人
        $jwtObject->setJti(md5(time())); // jwt id 用于标识该jwt
        $jwtObject->setNbf(time()+60*5); // 在此之前不可用

        $jwtObject->setData([
            'uid' => $user->id,
        ]);

        $token = $jwtObject->__toString();

        $this->writeJson(200, $token);
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