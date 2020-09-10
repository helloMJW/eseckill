<?php


namespace App\Model\User;

use EasySwoole\ORM\AbstractModel;

/**
 * Class UsersModel
 * @package App\Model\User
 */
class UsersModel extends AbstractModel
{
    protected $tableName = 'users';

    protected $primaryKey = 'id';

    public function storage($data) {
        return self::create()->data($data, false)->save();
    }

    public function login($username) {
        return self::get(['email' => $username]);
    }

    public function getInfoByUid($uid) {
        //TODO::不要返回密码字段
        return self::get(['id' => $uid]);
    }
}