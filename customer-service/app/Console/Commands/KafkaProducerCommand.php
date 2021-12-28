<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use PHPEasykafka\KafkaProducer;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class KafkaProducerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:produce-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a message on kafka';

    private $container;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $topicConfiguration = $this->container->get("KafkaTopicConfig");
        $brokerCollection = $this->container->get("KafkaBrokerCollection");

        $customer_id = Uuid::uuid4();

        Customer::create(
            [
                'id' => $customer_id,
                'name' => 'Lysa Legatti',
                'email' => 'lysa@email.com',
                'document' => '158.458.944-55',
                'phone' => '(19) 95484-4845',
                'address'=> 'endereco rua 10',
                'city' => 'limeira',
                'state'=> 'sp',
                'zipCode' => '13.481-035',
                'enabled' => "1"
            ]
        );

        $product_id = Uuid::uuid4();
        $order_id = Uuid::uuid4();

        $order = [
            'order' => [
                'id' => $order_id,
                'customer_id' => $customer_id,
                'status' => 0,
                'discount' => 5,
                'total' => 95,
                'order_date' => '2021-12-28',
                'return_date' => '2021-12-31',
                'items' => [
                    [
                        'id' => Uuid::uuid4(),
                        'order_id' => $order_id,
                        'product' => [
                            'id' => $product_id,
                            'name' => 'Celta',
                        ],
                        'qtd' => 1,
                        'total' => 100
                    ]
                ]
            ]
        ];

        $producer = new KafkaProducer(
            $brokerCollection,
            'orders',
            $topicConfiguration
        );

        $producer->produce(json_encode($order));


        return 0;
    }
}
