<?php

namespace IvaoBrasil\Infrastructure\Console;

use Illuminate\Console\Command;
use Illuminate\Process\Pool;
use Illuminate\Support\Facades\Process;
use LogicException as GlobalLogicException;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Module;
use RuntimeException as GlobalRuntimeException;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Exception\RuntimeException;

class BuildModuleResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'infra:build-resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds all resources from modules.';

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
        $modulesToBuild = $this->getAllModulesToWatch();
        $pool = $this->getBuildProcessPool($modulesToBuild);

        $this->info('Building resources...');
        $progressBar = $this->output->createProgressBar();

        $invokedPool = $pool->start(
            fn (string $type, string $output, string $key) =>
            $this->info(sprintf('[%s] - [%s] %s', $key, $type, $output), 'vvv')
        );
        $totalProcesses = $invokedPool->count();
        $progressBar->start($totalProcesses);

        $this->info(sprintf('Building %d modules.', $totalProcesses), 'v');

        while ($invokedPool->running()->count() > 0) {
            $progressBar->advance($totalProcesses - ($invokedPool->running()->count() + $progressBar->getProgress()));
        }

        $progressBar->finish();
        $this->newLine();

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
            // ['port', null, InputOption::VALUE_OPTIONAL, 'Specifies the initial port number to use.', self::INITIAL_PORT],
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
    private function getBuildProcessPool(array $modules): Pool
    {
        return Process::pool(function (Pool $pool) use ($modules) {
            foreach ($modules as $module) {
                $this->info(sprintf('Starting npm for %s module...', $module->getName()), 'vvv');
                $pool->as($module->getName())->path($module->getPath())->command('npm run build');
            }
        });
    }
}
