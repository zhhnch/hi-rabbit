<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use Hyperf\Amqp\Producer;
use App\Amqp\Producer\DemoProducer;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Utils\ApplicationContext;

/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hi Rabbit.",
        ];
    }

    public function amqp()
    {
        $time = date('Y-m-d H:i:s');
        $msg = $this->request->input('msg', '');
        $message = json_encode(compact('time', 'msg'));
        $demo = new DemoProducer($message);
        $producer = ApplicationContext::getContainer()->get(Producer::class);
        $result = $producer->produce($demo);
        return compact('result', 'message');
    }
}
