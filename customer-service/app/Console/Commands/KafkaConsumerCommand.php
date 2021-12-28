<?php

namespace App\Console\Commands;

use App\Handlers\OrderKafkaHandler;
use Illuminate\Console\Command;
use Psr\Container\ContainerInterface;

class KafkaConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume {topic} {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume a message from kafka';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ContainerInterface $container)
    {
        $this->info('Consuming topic from kafka');
        $topic = $this->argument('topic');
        $group = $this->argument('group');

        $configs = [
            'consumer' => [
                'enable.auto.commit' => 'false',
                'auto.commit.interval.ms' => '100',
                'offset.store.method' => 'broker',
                'auto.offset.reset' => 'smallest'
            ]
        ];

        $brokerCollection = $container->get("KafkaBrokerCollection");
        $consumer = new \PHPEasykafka\KafkaConsumer(
            $brokerCollection,
            [$topic],
            $group,
            $configs,
            $container
        );

        $consumer->consume(120 * 10000, [OrderKafkaHandler::class]);


        return 0;
    }
}
