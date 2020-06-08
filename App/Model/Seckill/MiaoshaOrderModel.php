<?php


namespace App\Model\Seckill;


use EasySwoole\ORM\AbstractModel;

class MiaoshaOrderModel extends AbstractModel
{
    protected $tableName = 'miaosha_order';

    protected $primaryKey = 'id';

    public function storage($data)
    {
        return self::create()->data($data, false)->save();
    }
}