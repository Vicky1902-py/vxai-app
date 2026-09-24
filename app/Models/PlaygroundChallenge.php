<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaygroundChallenge extends Model
{
    use HasFactory;

    protected $table = 'playground_challenges';

    protected $fillable = [
        'slug',
        'title',
        'level',
        'level_badge',
        'category',
        'desc',
        'instructions',
        'html_code',
        'css_code',
        'js_code',
        'order_num',
        'is_active',
    ];

    protected $casts = [
        'instructions' => 'array',
        'is_active' => 'boolean',
        'order_num' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_num', 'asc');
    }

    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function getCategoryLabelAttribute(): string
    {
        $categories = [
            'html' => 'HTML Dasar',
            'css' => 'CSS Layout & Desain',
            'javascript' => 'JavaScript DOM & Logika',
            'ai' => 'Kecerdasan Buatan (AI)',
            'responsive' => 'Desain Responsif',
            'fullstack' => 'Fullstack & Proyek Mini',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getLevelLabelAttribute(): string
    {
        $levels = [
            'pemula' => '🟢 Tingkat 1: Pemula',
            'menengah' => '🔵 Tingkat 2: Menengah',
            'mahir' => '🟣 Tingkat 3: Mahir',
        ];

        return $levels[$this->level] ?? ucfirst($this->level);
    }

    public function getLevelBadgeColorAttribute(): string
    {
        return match ($this->level) {
            'pemula' => 'bg-emerald-950 text-emerald-400 border-emerald-800',
            'menengah' => 'bg-blue-950 text-blue-400 border-blue-800',
            'mahir' => 'bg-purple-950 text-purple-400 border-purple-800',
            default => 'bg-slate-800 text-slate-300 border-slate-700',
        };
    }
}
