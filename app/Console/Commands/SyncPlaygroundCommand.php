<?php

namespace App\Console\Commands;

use App\Services\PlaygroundChallengeService;
use Illuminate\Console\Command;

class SyncPlaygroundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playground:sync {--force : Paksa reset ulang ke 10 modul tantangan default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi modul tantangan koding berjenjang Playground ke database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi modul tantangan Playground...');
        $force = (bool) $this->option('force');

        $result = PlaygroundChallengeService::syncDefaultChallenges($force);

        if ($result) {
            $this->info('Berhasil! Seluruh modul tantangan Playground telah disinkronkan ke database.');
        } else {
            $this->warn('Gagal melakukan sinkronisasi modul tantangan. Pastikan tabel playground_challenges sudah termigrasi.');
        }

        return 0;
    }
}
