<?php

namespace App\Handlers;

use App\Services\OrderService;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class OrderKafkaHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $consumer->commit();
        print_r('json_decode($message->payload)');
        print_r(json_decode($message->payload));
        $payload = json_decode($message->payload);

        $orderService = new OrderService($payload);
        $orderService->insert();
    }
}
