<?php

namespace App\Console\Commands;

use App\Services\ArticleContentService;
use Illuminate\Console\Command;

class SyncArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:sync {--force : Paksa sinkronisasi ulang seluruh artikel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi artikel tutorial berkualitas tinggi (Dasar Koding, Dasar AI, Belajar HTML) ke database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi artikel edukasi VxAI...');
        $force = (bool) $this->option('force');

        $result = ArticleContentService::syncDefaultArticles($force);

        if ($result) {
            $this->info('Berhasil! Seluruh artikel edukasi (Dasar Koding, Dasar AI, Belajar HTML) telah diperbarui di database.');
        } else {
            $this->info('Database artikel sudah up-to-date (versi terkini). Tidak ada perubahan yang diperlukan.');
        }

        return 0;
    }
}
