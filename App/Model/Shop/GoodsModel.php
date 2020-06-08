<?php


namespace App\Model\Shop;


use EasySwoole\ORM\AbstractModel;

class GoodsModel extends AbstractModel
{
    protected $tableName = 'goods';

    protected $primaryKey = 'id';

    public function getLists()
    {

    }

    /**
     * 获取单条数据
     * @param $id
     * @return GoodsModel|array|bool|null
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function detail($id)
    {
        return $this->get(['id' => $id]);
    }
}