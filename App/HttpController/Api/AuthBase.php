<?php


namespace App\HttpController\Api;


use App\HttpController\BaseController;
use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;

class AuthBase extends BaseController
{
    protected $uid;
    protected $token;

    protected function onRequest(?string $action): ?bool
    {
        $header = $this->request()->getHeaders();

        if(isset($header['token'])) {
            $this->token = $header ['token'][0];
        }

        try {

            $jwtObject = Jwt::getInstance()->decode($this->token);

            $status = $jwtObject->getStatus();
            // 如果encode设置了秘钥,decode 的时候要指定
            // $status = $jwt->setSecretKey('easyswoole')->decode($token)

            switch ($status)
            {
                case  1:
                    $this->uid = $jwtObject->getData()['uid'];
                    break;
                case  -1:
                    $this->writeJson(400, null, 'token无效');
                    return false;
                    break;
                case  -2:
                    $this->writeJson(400, null, 'token过期');
                    return false;
                    break;
            }
        } catch (\EasySwoole\Jwt\Exception $e) {

        }

        $ret =  parent::onRequest($action);
        if($ret === false){
            return false;
        }
        $v = $this->validateRule($action);
        if($v){
            $ret = $this->validate($v);
            if($ret == false){
                $this->writeJson(Status::CODE_BAD_REQUEST,null,"{$v->getError()->getField()}@{$v->getError()->getFieldAlias()}:{$v->getError()->getErrorRuleMsg()}");
                return false;
            }
        }
        return true;
    }


}