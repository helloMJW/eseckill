<?php


namespace App\Model\Seckill;


use EasySwoole\ORM\AbstractModel;

class MiaoshaGoodsModel extends AbstractModel
{
    protected $tableName = 'miaosha_goods';

    protected $primaryKey = 'id';

    public function getStock($id) {
        $result = self::create()->where(['goods_id' => $id])->val('stock_count');
        return $result;
    }

    public function updateStock($id) {
        return self::create()->update(['stock_count' => QueryBuilder::dec(1)], ['id' => $id]);
    }

}