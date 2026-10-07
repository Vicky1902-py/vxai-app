<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'thumbnail_url',
        'author_id',
        'author_name',
        'views_count',
        'status',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    // Relasi ke User pembuat
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope Artikel yang Tayang Publik
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope Artikel Utama (Featured)
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Label Kategori Ramah Pengguna
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'web', 'coding' => 'Coding & Web',
            'ai' => 'Tips & Trik AI',
            'teknologi' => 'Tren Teknologi',
            'komputer' => 'Komputer & PC',
            'android' => 'Tips Android',
            default => 'Teknologi Terkini',
        };
    }

    // Ikon Kategori
    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'web', 'coding' => '💻',
            'ai' => '🤖',
            'teknologi' => '🌐',
            'komputer' => '🖥️',
            'android' => '📱',
            default => '📰',
        };
    }

    // Badge Warna Kategori Tailwind
    public function getCategoryBadgeClassesAttribute(): string
    {
        return match ($this->category) {
            'web', 'coding' => 'bg-blue-100 text-blue-700 border-blue-200',
            'ai' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
            'teknologi' => 'bg-sky-100 text-sky-700 border-sky-200',
            'komputer' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'android' => 'bg-teal-100 text-teal-700 border-teal-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    // Perkiraan Waktu Baca (Kata per Menit)
    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        $minutes = max(1, ceil($words / 200));
        return $minutes . ' menit baca';
    }

    // Gambar Sampul Fallback
    public function getSafeThumbnailAttribute(): string
    {
        if (!empty($this->thumbnail_url)) {
            if (str_starts_with($this->thumbnail_url, 'http://') || str_starts_with($this->thumbnail_url, 'https://') || str_starts_with($this->thumbnail_url, '//')) {
                return $this->thumbnail_url;
            }
            return asset(ltrim($this->thumbnail_url, '/'));
        }

        return match ($this->category) {
            'web', 'coding' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1000&q=80',
            'ai' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=1000&q=80',
            'teknologi' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1000&q=80',
            'komputer' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1000&q=80',
            'android' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1000&q=80',
            default => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1000&q=80',
        };
    }

    // Format Tanggal Indonesia Singkat: 05 Okt 2026
    public function getFormattedDateAttribute(): string
    {
        $dt = $this->published_at ?? $this->created_at ?? now();
        $bulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        return $dt->format('d') . ' ' . ($bulanIndo[(int)$dt->format('m')] ?? $dt->format('M')) . ' ' . $dt->format('Y');
    }

    // Format Tanggal Indonesia Lengkap: Senin, 05 Oktober 2026
    public function getFormattedFullDateAttribute(): string
    {
        $dt = $this->published_at ?? $this->created_at ?? now();
        $hariIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $bulanLengkap = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $hari = $hariIndo[$dt->format('l')] ?? $dt->format('l');
        $bulan = $bulanLengkap[(int)$dt->format('m')] ?? $dt->format('F');

        return "{$hari}, " . $dt->format('d') . " {$bulan} " . $dt->format('Y');
    }

    // URL Profil Penulis E-E-A-T
    public function getAuthorUrlAttribute(): string
    {
        return route('public.author', ['slug' => \Illuminate\Support\Str::slug($this->author_name ?? 'vicky-koroh')]);
    }
}
