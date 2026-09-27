<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'subcategory_id', 'type',
        'name', 'detail', 'price',
        'country', 'state', 'city', 'area',
        'image', 'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilter($query, Request $request)
    {
        return $query->active()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->q.'%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('detail', 'like', $term)
                        ->orWhere('city', 'like', $term)
                        ->orWhere('area', 'like', $term);
                });
            })
            ->when($request->filled('city'), fn ($q) => $q->where('city', $request->city))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', (float) $request->min_price))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', (float) $request->max_price))
            ->when($request->filled('subcategory'), function ($q) use ($request) {
                $q->whereHas('subcategory', fn ($sq) => $sq->where('slug', $request->subcategory));
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                match ($request->sort) {
                    'price_low' => $q->orderBy('price', 'asc'),
                    'price_high' => $q->orderBy('price', 'desc'),
                    'oldest' => $q->orderBy('created_at', 'asc'),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest());
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹'.number_format($this->price);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'data:image') || str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        $path = ltrim($this->image, '/');
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
