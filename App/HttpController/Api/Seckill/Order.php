<?php


namespace App\HttpController\Api\Seckill;


use App\HttpController\Api\ApiBase;
use App\Model\Seckill\MiaoshaGoodsModel;
use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\GoodsModel;
use App\Model\Shop\OrderInfoModel;
use App\Producer\OrderProducer;
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


        // 接收请求
        $log = 'goods_id:'. $goodsId . ' time' . microtime();
        Logger::getInstance()->log($log,Logger::LOG_LEVEL_INFO,'DEBUG');


        $redisObj = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        $stockKey = "goods:id:" . $goodsId;
        $stockKeySign = "goods:stock:id:" . $goodsId;


        if(!$redisObj->get($stockKeySign)) {
            $this->writeJson(0, null, '参数错误');
            \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
            return false;
        }
        //TODO::增加分布式锁处理
        $stock = $redisObj->decr($stockKey);
        if($stock < 0) {
            $redisObj->set($stockKeySign, 0);
            $this->writeJson(0, null, '库存不足');
            \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
            return false;
        }
        \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
        //TODO::消息队列处理-生产者
        /**
         * 消息队列消费的时候处理
         * 获取goods_id详细信息
         * 获取address_id详细信息
         * 获取uid详细信息
         * 插入mysql
         * 通知用户短信、邮箱、APP
         */
        $orderProducer = new OrderProducer();
        $orderProducer->main(['goodsId' => $goodsId, 'uid' => time()]);

    }

    public function getRedis()
    {
        $redisObj = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redisObj);
        $this->writeJson(0, null, 'success ok');
    }

    /**
     * 直接返回
     */
    public function testHttp()
    {
        $this->writeJson(0, null, 'hello world');
    }
}