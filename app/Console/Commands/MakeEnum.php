<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Enum';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Enums/' . $name . '.php');

        // Check tồn tại file
        if (File::exists($path)) {
            $this->error('[ERROR] Enum already exists!');
        }

        // Tạo thư mục nếu chưa tồn tại
        File::ensureDirectoryExists(dirname($path));

        // Get content từ stub
        $stub = File::get(__DIR__ . '/stubs/enum.stub');
        File::put($path, str_replace('{enumName}', $name, $stub));

        $this->getOutput()->writeln('<fg=white;bg=blue> INFO </> Create Enum Succesfully in [' . $path . ']');
    }
}
