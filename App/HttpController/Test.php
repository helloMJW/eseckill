<?php


namespace App\HttpController;


use EasySwoole\EasySwoole\SysConst;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\AtomicLimit\AtomicLimit;
use EasySwoole\Component\Di;
use EasySwoole\Log\LoggerInterface;

// 上下文管理器
use EasySwoole\Component\Context\ContextManager;

// 邮件
use EasySwoole\Smtp\Mailer;
use EasySwoole\Smtp\MailerConfig;
use EasySwoole\Smtp\Message\Html;
use EasySwoole\Smtp\Message\Attach;

//消息队列
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use App\Producer\OrderProducer;

class Test extends Controller
{
    public function index(){


        ## order queue kafka
        $orderProducer = new OrderProducer();
        $orderProducer->main(['uid' => 1, 'oid' => 100]);

        ## kafka

//        $connectionFactory = new RdKafkaConnectionFactory([
//            'global' => [
//                'group.id' => uniqid('', true),
//                'metadata.broker.list' => '192.168.3.118:32772',
//                'enable.auto.commit' => 'false',
//            ],
//            'topic' => [
//                'auto.offset.reset' => 'beginning',
//            ],
//        ]);
//
//        $context = $connectionFactory->createContext();

//        $message = $context->createMessage('Hello world!');
//
//        $fooTopic = $context->createQueue('hello');
//
//        $context->createProducer()->send($fooTopic, $message);

//        $message = $context->createMessage('Hello world!');
//
//        $fooQueue = $context->createQueue('hello');
//
//        $context->createProducer()->send($fooQueue, $message);

//        $fooQueue = $context->createQueue('hello');
//
//        $consumer = $context->createConsumer($fooQueue);
//
//        $message = $consumer->receive();
//        var_dump($message);
//        $consumer->acknowledge($message);
//
//        $this->writeJson(200, null, null);

        # 读取文本输出
        // $this->response()->write(file_get_contents(EASYSWOOLE_ROOT . '/phpinfo.html'));

        ## 自定义进程

//        $a = \EasySwoole\Component\Process\Manager::getInstance()->info();
//        var_dump($a);


        ## 上下文PID获取
//        $cid = ContextManager::getInstance()->getCid();
//        var_dump($cid);
//        $this->writeJson(200, null, 1);
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