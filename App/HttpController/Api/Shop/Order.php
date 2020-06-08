<?php


namespace App\HttpController\Api\Shop;


use App\HttpController\Api\ApiBase;
use App\Model\Shop\OrderInfoModel;

class Order extends ApiBase
{
    public function user()
    {
        //接收参数
        $input = $this->request()->getRequestParam();
        //TODO::验证参数 验证库存

        //TODO::保存订单
        $model = new OrderInfoModel();
        $res = $model->storage($input);
        $this->writeJson(200, null, 'success');
    }
}