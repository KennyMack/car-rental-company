<?php

namespace App\Observers;

use App\Models\Order;
use PHPEasykafka\KafkaProducer;
use Psr\Container\ContainerInterface;

class OrderObserver
{
    private $topicConfiguration;
    private $brokerCollection;
    private $producer;

    public function __construct(ContainerInterface $container)
    {
        $this->topicConfiguration = $container->get("KafkaTopicConfig");
        $this->brokerCollection = $container->get("KafkaBrokerCollection");

        $this->producer = new KafkaProducer(
            $this->brokerCollection,
            'orders',
            $this->topicConfiguration
        );
    }

    private function produceMessage(Order $order)
    {
        $preparedOrder = [
            'order' => [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'status' => $order->status,
                'discount' => $order->discount,
                'total' => $order->total,
                'order_date' => $order->order_date->format('y-m-d'),
                'return_date' => $order->return_date->format('y-m-d')
            ]
        ];

        $preparedItems = [];

        foreach ($order->items as $item) {
            $items['id'] = $item->id;
            $items['order_id'] = $item->order_id;
            $items['qtd'] = $item->qtd;
            $items['total'] = $item->qtd * $item->product->price;
            $items['product']['id'] = $item->product->id;
            $items['product']['name'] = $item->product->name;

            $preparedItems[] = $items;
        }

        $preparedOrder['order']['items'] = $preparedItems;

        $this->producer->produce(json_encode($preparedOrder));
    }

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->adjustTotal();
        $this->produceMessage($order);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $order->adjustTotal();
        $order->adjustBalance();
        $this->produceMessage($order);
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
