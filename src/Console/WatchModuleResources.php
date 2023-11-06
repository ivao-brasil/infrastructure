<?php

namespace IvaoBrasil\Infrastructure\Console;

use Illuminate\Console\Command;
use Illuminate\Process\Pool;
use Illuminate\Support\Facades\Process;
use LogicException as GlobalLogicException;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Module;
use RuntimeException as GlobalRuntimeException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Exception\RuntimeException;

class WatchModuleResources extends Command
{
    private const INITIAL_PORT = 5173;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'infra:watch-resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watches all resources from modules.';

    private bool $shouldKeepRunning = true;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private RepositoryInterface $moduleRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modulesToWatch = $this->getAllModulesToWatch();
        $pool = $this->getWatchProcessPool($modulesToWatch)
            ->start(
                fn (string $type, string $output, string $key) =>
                $this->info(sprintf('[%s] - [%s] %s', $key, $type, $output), 'vvv')
            );

        $this->info(sprintf('Running %d workers.', $pool->count()), 'v');
        $this->info('Workers are running, waiting for exit signals.');
        $this->trap([SIGTERM, SIGINT], function () use ($pool) {
            $this->shouldKeepRunning = false;
            $pool->signal(SIGINT);
            $this->newLine();
        });

        while ($this->shouldKeepRunning && $pool->running()) {
            //
        }

        return self::SUCCESS;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['port', null, InputOption::VALUE_OPTIONAL, 'Specifies the initial port number to use.', self::INITIAL_PORT],
        ];
    }

    /**
     * Gets all modules to watch resources from.
     *
     * @return Module[]
     */
    private function getAllModulesToWatch(): array
    {
        $result = [];
        $modules = $this->moduleRepository->allEnabled();
        foreach ($modules as $module) {
            /** @var Module $module */
            $modulePath = $module->getPath();
            if (
                !file_exists($modulePath . DIRECTORY_SEPARATOR . 'package.json') ||
                !file_exists($modulePath . DIRECTORY_SEPARATOR . 'vite.config.js')
            ) {
                $this->warn(sprintf('Ignoring module %s...', $module->getName()));
                continue;
            }

            $this->info(sprintf('Adding %s module to watch list...', $module->getName()), 'vvv');
            $result[] = $module;
        }

        return $result;
    }

    /**
     * Gets the process pool for the given modules.
     *
     * @param Module[] $modules
     * @return Pool
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws GlobalLogicException
     * @throws GlobalRuntimeException
     */
    private function getWatchProcessPool(array $modules): Pool
    {
        $port = self::INITIAL_PORT;
        return Process::pool(function (Pool $pool) use ($modules, $port) {
            foreach ($modules as $module) {
                $this->info(sprintf('Starting npm for %s module at port %s...', $module->getName(), $port), 'vvv');
                $pool
                    ->as($module->getName())
                    ->path($module->getPath())
                    ->command(sprintf('npm run dev -- --port %s', $port));
                $port++;
            }
        });
    }
}
