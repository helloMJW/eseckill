<?php


namespace App\HttpController\Api\Shop;


use App\HttpController\Api\ApiBase;
use App\Model\Shop\GoodsModel;

class Goods extends ApiBase
{

    public function index() {
        $this->writeJson(200, [], 'success');
        return true;
    }

    public function detail()
    {
        $id = $this->input('id');

        $model = new GoodsModel();
        $data = $model->detail($id);
        $this->writeJson(200, $data, 'success');
        return true;
    }
}