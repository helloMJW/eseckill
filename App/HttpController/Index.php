<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{



    public function index()
    {
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/welcome.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    public function test()
    {
        $redis=\EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        if(!$res=$redis->get("stock")){
            $redis->set("stock", 10);
//            $redis->expire("name",-1);
        }
//        $redis->set("stock", 10);
        $res=$redis->get("stock");
        \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);

        return $this->writeJson(200,$res);

    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }
}