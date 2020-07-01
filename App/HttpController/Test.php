<?php


namespace App\HttpController;


use EasySwoole\EasySwoole\SysConst;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\AtomicLimit\AtomicLimit;
use EasySwoole\Component\Di;
use EasySwoole\Log\LoggerInterface;

// 邮件
use EasySwoole\Smtp\Mailer;
use EasySwoole\Smtp\MailerConfig;
use EasySwoole\Smtp\Message\Html;
use EasySwoole\Smtp\Message\Attach;

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

    /**
     * 测试邮件发送
     * QQ邮箱需要授权码(就是用于smtp客户端的密码) https://service.mail.qq.com/cgi-bin/help?subtype=1&&no=1001256&&id=28
     * @throws \EasySwoole\Smtp\Exception\Exception
     * @throws \EasySwoole\Smtp\Exception\FileNotFoundException
     */
    public function email()
    {
        $config = new MailerConfig();
        $config->setServer('smtp.qq.com');
        $config->setSsl(true);
        $config->setUsername('xxx@xxx.com');
        $config->setPassword('xxxxxx');
        $config->setMailFrom('xxx@xxx.com');
        $config->setTimeout(10);//设置客户端连接超时时间
        $config->setMaxPackage(1024*1024*5);//设置包发送的大小：5M

        //设置文本或者html格式
        $mimeBean = new Html();
        $mimeBean->setSubject('Hello Word!');
        $mimeBean->setBody('<h1>Hello Word</h1>');

        //添加附件
//        $mimeBean->addAttachment(Attach::create('./test.txt'));

        $mailer = new Mailer($config);
        $mailer->sendTo('xxx@qq.com', $mimeBean);
    }
}