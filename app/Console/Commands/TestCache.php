<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TestCache extends Command
{
    protected $signature = 'cache:test';
    protected $description = 'Test Cache Storage';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Contoh salah: Menyimpan Closure dalam cache
        // Cache::put('key', function() { return 'Hello'; });

        // Contoh benar: Menyimpan data sederhana dalam cache
        Cache::put('key', 'Hello');

        // Mengambil data dari cache
        $value = Cache::get('key');
        $this->info('Cache value: ' . $value); // Menampilkan hasil di console
    }
}
