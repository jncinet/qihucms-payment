<?php

namespace Qihucms\Payment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayOrder extends Model
{
    protected $fillable = [
        'user_id', 'orderable_type', 'orderable_id', 'driver', 'gateway', 'type',
        'subject', 'total_amount', 'params', 'result', 'status'
    ];

    protected $casts = [
        'params' => 'array',
        'result' => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orderable()
    {
        return $this->morphTo();
    }
}