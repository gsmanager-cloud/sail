<?php

namespace GSManager\Sail\Console;

use GSManager\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'sail:publish')]
class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sail:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the GSManager Sail Docker files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'sail-docker']);
        $this->call('vendor:publish', ['--tag' => 'sail-database']);

        file_put_contents(
            $this->gsmanager->basePath('docker-compose.yml'),
            str_replace(
                [
                    './vendor/gsmanager/sail/runtimes/8.4',
                    './vendor/gsmanager/sail/runtimes/8.3',
                    './vendor/gsmanager/sail/runtimes/8.2',
                    './vendor/gsmanager/sail/runtimes/8.1',
                    './vendor/gsmanager/sail/runtimes/8.0',
                    './vendor/gsmanager/sail/database/mysql',
                    './vendor/gsmanager/sail/database/pgsql'
                ],
                [
                    './docker/8.4',
                    './docker/8.3',
                    './docker/8.2',
                    './docker/8.1',
                    './docker/8.0',
                    './docker/mysql',
                    './docker/pgsql'
                ],
                file_get_contents($this->gsmanager->basePath('docker-compose.yml'))
            )
        );
    }
}
