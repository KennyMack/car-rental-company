<?php

namespace App\Console\Commands;

use App\Models\Product;
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
    protected $signature = 'kafka:produce-product';

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
     * @param ContainerInterface $container
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

        $product_id = Uuid::uuid4();

        $product = Product::create(
            [
                'id' => $product_id,
                'name' => 'F-250',
                'description' => '2.8 cabine simples',
                'price' => '189.9',
                'qtdAvailable' => '1',
                'qtdTotal' => '1'
            ]
        );

        $producer = new KafkaProducer(
            $brokerCollection,
            'products',
            $topicConfiguration
        );

        $producer->produce($product->toJson());
        return 0;
    }
}
