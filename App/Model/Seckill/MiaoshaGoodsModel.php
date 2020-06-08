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


        $result = self::create()->func(function ($builder){
            $builder->selectForUpdate()->where('goods_id', 2)->getOne($this->tableName);
        });

//        $result = self::create()->where(['goods_id' => $id])->val('stock_count');
        return $result [0]['stock_count'];
    }

    public function updateStock($id) {
        return self::create()->update(['stock_count' => QueryBuilder::dec(1)], ['goods_id' => $id]);
    }

}