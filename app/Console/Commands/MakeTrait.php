<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name : The name of the trait}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $traitName = $this->qualifyClass($name);
        $path = $this->getPath($traitName);

        // Đảm bảo thư mục tồn tại
        $this->makeDirectory($path);

        // Kiểm tra trait đã tồn tại chưa
        if (File::exists($path)) {
            $this->error("Trait {$traitName} already exists!");
            return;
        }

        // Tạo nội dung trait
        File::put($path, $this->buildClass($traitName));

        $this->info("Trait {$traitName} created successfully!");
    }

    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');
        $name = str_replace('/', '\\', $name);
        return 'App\\Traits\\' . $name;
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

    protected function buildClass($name)
    {
        $stub = File::get(__DIR__ . '/stubs/trait.stub');
        return str_replace('{{traitName}}', class_basename($name), $stub);
    }
}
