<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED  = 'completed';
    public const STATUS_CANCELED   = 'canceled';

    public const STATUSES = [
        self::STATUS_PROCESSING,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELED,
    ];

    protected $fillable = [
        'user_id','total','currency','status',
        'provider','provider_order_id','meta',
        'error_code','error_message',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }

    // (اختیاری) برای Badge در Blade:
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_COMPLETED  => 'تکمیل شده',
            self::STATUS_CANCELED   => 'لغو شده',
            default                 => 'در حال پردازش',
        };
    }
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_COMPLETED  => 'bg-green-100 text-green-700 ring-green-600/20',
            self::STATUS_CANCELED   => 'bg-red-100 text-red-700 ring-red-600/20',
            default                 => 'bg-amber-100 text-amber-700 ring-amber-600/20',
        };
    }
}