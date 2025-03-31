<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Interface service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $name = $this->argument('name');
        $path = app_path('Contracts/' . $name . '.php');

        // Kiểm tra tồn tại
        if (File::exists($path)) {
            $this->error("[ERROR] Helper {$name} already exists!");
            return;
        }

        // Tạo thư mục nếu chưa tồn tại
        File::ensureDirectoryExists(dirname($path));

        // Copy từ stub
        $stub = File::get(__DIR__ . '/stubs/interface.stub');
        File::put($path, str_replace('{interfaceName}', $name, $stub));

        $this->getOutput()->writeln('<fg=white;bg=blue> INFO </> Create interface successfully in [' . $path . ']');
    }
}
