<?php


namespace App\Logic;

use App\Model\Seckill\MiaoshaOrderModel;
use App\Model\Shop\GoodsModel;
use App\Model\Shop\OrderInfoModel;

/**
 * 秒杀订单业务处理
 * Class MiaoshaOrderLogic
 * @package App\Logic
 */
class MiaoshaOrderLogic extends BaseLogic
{
    public function save($goodsId, $uid) {

        $goodsModel = new GoodsModel();
        $orderInfoModel = new OrderInfoModel();
        $miaoshaOrderModel = new MiaoshaOrderModel();

        $goodsInfo = $goodsModel->detail($goodsId);

        $orderInfo = $goodsInfo->toArray();
        unset($orderInfo ['id']);
        $orderInfo ['user_id'] = $uid;
//
        $oid = $orderInfoModel->storage($orderInfo);
        $miaoshaOrderModel->storage(['user_id' => $uid, 'order_id' => $oid, 'goods_id' => $goodsId]);
        //TODO::短信、推送、页面、邮件通知用户
    }
}