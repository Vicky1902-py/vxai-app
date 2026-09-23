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
            'coding' => 'Coding & Web',
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
            'coding' => '💻',
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
            'coding' => 'bg-blue-100 text-blue-700 border-blue-200',
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
            return $this->thumbnail_url;
        }

        return match ($this->category) {
            'coding' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1000&q=80',
            'ai' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=1000&q=80',
            'teknologi' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1000&q=80',
            'komputer' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1000&q=80',
            'android' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1000&q=80',
            default => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1000&q=80',
        };
    }
}
