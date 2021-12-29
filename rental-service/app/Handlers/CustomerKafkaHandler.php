<?php


namespace App\Handlers;


use App\Models\Customer;
use PHPEasykafka\KafkaConsumerHandlerInterface;

class CustomerKafkaHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);
        print_r($payload);
        Customer::firstOrCreate(
            ['id' => $payload->id],
            [
                'name' => $payload->name,
                'email' => $payload->email,
                'phone' => $payload->phone,
                'document' => $payload->document
            ]
        );
        $consumer->commit();
    }

}
