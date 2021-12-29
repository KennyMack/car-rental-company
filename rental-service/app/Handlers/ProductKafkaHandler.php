<?php


namespace App\Handlers;


use App\Models\Product;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class ProductKafkaHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);
        print_r($payload);
        Product::firstOrCreate(
            ['id' => $payload->id],
            [
                'name' => $payload->name,
                'price' => $payload->price
            ]
        );
        $consumer->commit();
    }

}
