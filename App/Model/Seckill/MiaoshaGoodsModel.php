<?php


namespace App\Model\Seckill;


use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

class MiaoshaGoodsModel extends AbstractModel
{
    protected $tableName = 'miaosha_goods';

    protected $primaryKey = 'id';

    public function getStock($id) {
        $result = self::create()->where(['goods_id' => $id])->val('stock_count');
        return $result;
    }

    public function updateStock($id, $stock) {
        return self::create()->update(['stock_count' => QueryBuilder::dec(1)], ['goods_id' => $id, 'stock_count' => [$stock, '>=']]);
    }

}