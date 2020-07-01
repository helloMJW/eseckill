<?php


namespace App\HttpController\Api\Seckill;


use App\HttpController\Api\ApiBase;
use App\Model\Seckill\MiaoshaGoodsModel;
use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\OrderInfoModel;
use EasySwoole\ORM\DbManager;

class Order extends ApiBase
{
    /**
     * 功能流程
     * 1. 用户登录 进入秒杀页面
     * 2. 点击秒杀按钮(秒杀成功 或 等待中 或 未付款还有机会)
     * 3. 接收秒杀成功短信(邮件) 填写收货地址 付款 等待收货
     *
     *
     * 系统流程
     * 1. 验证用户是否登录
     * 2. 用户是否正常用户(非机器刷单)
     * 3. 限流器
     * 4. 校验库存
     * 5. 更新库存 生成订单
     * 6. 接收付款 完结订单
     *
     * @return bool|void
     * @throws \Throwable
     */

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
                $orderInfoModel = new OrderInfoModel();
                $miaoshaOrderModel = new MiaoshaOrderModel();
                $oid = $orderInfoModel->storage($input);
                $input ['order_id'] = $oid;
                $miaoshaOrderModel->storage($input);
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