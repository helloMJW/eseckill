<?php


namespace App\HttpController\Api\Seckill;


use App\HttpController\Api\ApiBase;
use App\Model\Seckill\MiaoshaGoodsModel;
use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\OrderInfoModel;
use EasySwoole\ORM\DbManager;

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

        $miaoshaGoodsModel = new MiaoshaGoodsModel();
        $stock = $miaoshaGoodsModel->getStock($input ['id']);

        if($stock <= 0) {
            $this->writeJson(0, null, '库存不足');
            return false;
        } else {
            $orderInfoModel = new OrderInfoModel();
            $miaoshaOrderModel = new MiaoshaOrderModel();
            $oid = $orderInfoModel->storage($input);
            $input ['order_id'] = $oid;
            $miaoshaOrderModel->storage($input);
            $this->writeJson(1, null, 'ok');
        }

    }
}