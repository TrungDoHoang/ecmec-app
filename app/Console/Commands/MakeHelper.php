<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name : Helper name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a helper';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $helperName = $this->qualifyClass($name);
        $path = $this->getPath($helperName);

        // Đảm bảo thư mục tồn tại
        $this->makeDirectory($path);

        if (File::exists($path)) {
            $this->error("ERROR Helper {$helperName} already exists!");
            return;
        }

        File::put($path, $this->buildContent());

        $this->getOutput()->writeln([
            '<fg=white;bg=blue> INFO </> Console command [' . $path . '] created successfully. Don\'t forget edit composer <comment>autoload.file</comment> and run "<comment>composer dump-autoload</comment>"'
        ]);
    }

    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');
        $name = str_replace('/', '\\', $name);
        return 'App\\Helpers\\' . $name;
    }

    protected function getPath($name)
    {
        $name = str_replace('App\\', '', $name);
        return app_path(str_replace('\\', '/', $name) . '.php');
    }

    protected function makeDirectory($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function buildContent()
    {
        $stub = File::get(__DIR__ . '/stubs/helper.stub');
        return $stub;
    }
}
