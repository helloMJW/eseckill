<?php


namespace App\Model\Shop;


use EasySwoole\ORM\AbstractModel;

class OrderInfoModel extends AbstractModel
{
    protected $tableName = 'order_info';

    protected $primaryKey = 'id';

    public function storage($data) {
        return self::create()->data($data, false)->save();
    }
}