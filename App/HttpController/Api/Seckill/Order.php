<?php


namespace App\HttpController\Api\Seckill;


use App\HttpController\Api\ApiBase;
use App\Model\Seckill\MiaoshaGoodsModel;
use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\OrderInfoModel;
use EasySwoole\ORM\DbManager;

class Order extends ApiBase
{
    public function index() {
//        $id = $this->input('id');
        $input = $this->request()->getRequestParam();

        //TODO::验证活动状态

        //TODO::验证库存
        $redis = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        //DbManager::getInstance()->startTransaction();
        try{

//            $model = new MiaoshaGoodsModel();
//            $model->updateStock($input ['goods_id']);
//
//            $stock = $model->getStock($input ['goods_id']);
            $stock = $redis->get("stock");
            if($stock <= 0) {
                $this->writeJson(0, null, '库存不足');
                 //throw new \Exception('库存不足');
                return false;
            } else {
                $redis->decr("stock");
                //TODO::用户是否已有订单
                //TODO::保存订单
//                $orderInfoModel = new OrderInfoModel();
//                $miaoshaOrderModel = new MiaoshaOrderModel();
//                $oid = $orderInfoModel->storage($input);
//                $input ['order_id'] = $oid;
//                $miaoshaOrderModel->storage($input);
                $this->writeJson(1, null, 'ok');
            }
        } catch (\Throwable  $e) {
//            var_dump($e->getMessage());
            //DbManager::getInstance()->rollback();
        } finally {

            \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);

            //DbManager::getInstance()->commit();
        }
    }
}