<?php


namespace App\Model\User;


use EasySwoole\ORM\AbstractModel;

class UsersModel extends AbstractModel
{
    protected $tableName = 'users';

    protected $primaryKey = 'id';

    public function storage($data) {
        return self::create()->data($data, false)->save();
    }
}