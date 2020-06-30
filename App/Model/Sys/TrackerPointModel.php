<?php


namespace App\Model\Sys;

use EasySwoole\ORM\AbstractModel;

class TrackerPointModel extends AbstractModel
{
    protected $tableName = 'tracker_point';

    protected $primaryKey = 'id';

    public function storage($data) {
        return self::create()->data($data, false)->save();
    }
}