<?php


namespace App\HttpController\Api;

use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;
use EasySwoole\Validate\Validate;
use App\HttpController\BaseController;

class ApiBase extends BaseController
{
    protected $input;
    protected $token;

    protected function onRequest(?string $action): ?bool
    {
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