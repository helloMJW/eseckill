<?php


namespace App\HttpController\Api\Seckill;


use App\HttpController\Api\ApiBase;
use App\Model\Seckill\MiaoshaGoodsModel;
use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\OrderInfoModel;
use EasySwoole\ORM\DbManager;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Swoole\Coroutine;
use EasySwoole\EasySwoole\Logger;
/**
 * 秒杀生成订单
 * Class Order
 * @package App\HttpController\Api\Seckill
 */
class Order extends ApiBase
{
    /**
     * 规则说明
     * 1. 到达指定时间开始秒杀(倒计时)
     * 2. 一个用户只能秒杀一个
     * 3. 秒杀成功后用户需要在15分钟内付款完毕 否则回到秒杀商品中
     *
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

        $input = $this->request()->getRequestParam();
        $goodsId = $input ['goods_id'];
        $mark = $input ['mark'] ?? 'none';
        
        // 接收请求
        $log = 'mark:' . $mark . 'goods_id:'. $goodsId . ' time' . microtime();
        Logger::getInstance()->log($log,Logger::LOG_LEVEL_INFO,'DEBUG');
        
        
        try {
            $miaoshaGoodsModel = new MiaoshaGoodsModel();
        }catch (\Exception $e) {
            var_dump($e->getMessage());
        }



        $redisObj = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        $stockKey = "goods:id:" . $goodsId;
        $stockKeySign = "goods:stock:id:" . $goodsId;
        $cid = Coroutine::getCid(); // 如果不是协程环境返回-1

//        echo $cid . PHP_EOL;
//        echo PHP_INT_MAX;

        // goods:id:1 = 100;
        if(!$redisObj->exists($stockKey)) {
//            $miaoshaGoodsModel = new MiaoshaGoodsModel();
            $stock = $miaoshaGoodsModel->getStock($goodsId);
            $redisObj->set($stockKey, $stock);
            $redisObj->set($stockKeySign, 1);
        }

        if(!$redisObj->get($stockKeySign)) {
            $this->writeJson(0, null, '库存不足');
            \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
            return false;
        }

        $stock = $redisObj->decr($stockKey);

//        $log = 'cid:' . $cid . ' stock:' . $stock . ' time:' . time();
//
//        Logger::getInstance()->log($log,Logger::LOG_LEVEL_INFO,'DEBUG');//记录info级别日志//例子后面2个参数默认值


        if($stock < 0) {
            $redisObj->set($stockKeySign, 0);
            $this->writeJson(0, null, '库存不足');
            \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
            return false;
        }
//        $miaoshaGoodsModel = new MiaoshaGoodsModel();
        \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
        try{
            //开启事务
            DbManager::getInstance()->startTransaction();

//            $miaoshaGoodsModel->updateStock($goodsId);
//            $stock = $miaoshaGoodsModel->getStock($goodsId);

//            if($stock < 0) {
//                $this->writeJson(0, null, '库存不足');
//                throw new \Exception('库存不足');
//                return false;
//            } else {

                $orderInfoModel = new OrderInfoModel();
                $miaoshaOrderModel = new MiaoshaOrderModel();
                $oid = $orderInfoModel->storage($input);
                $input ['order_id'] = $oid;
                $miaoshaOrderModel->storage($input);
                $this->writeJson(1, null, 'ok');
//            }

        } catch(\Throwable  $e){
            //回滚事务
            DbManager::getInstance()->rollback();
        } finally {
            //提交事务
            DbManager::getInstance()->commit();
        }





    }
}