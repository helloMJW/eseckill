<?php


namespace App\HttpController;


use EasySwoole\EasySwoole\SysConst;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\AtomicLimit\AtomicLimit;
use EasySwoole\Component\Di;
use EasySwoole\Log\LoggerInterface;

class Test extends Controller
{
    public function index(){
        $this->writeJson(200, null, 1);
    }

    public function atomic() {
        if(!AtomicLimit::isAllow('api')) {
            $this->writeJson(400, null, 'api refuse');
        } else {
            file_put_contents('./Log/atomic.txt', 'ssss' . PHP_EOL, FILE_APPEND);
            $this->writeJson(200, null, 1);
        }
    }
}