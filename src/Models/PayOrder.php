<?php

namespace Qihucms\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PayOrder extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'orderable_type', 'orderable_id', 'driver', 'gateway', 'type',
        'subject', 'total_amount', 'params', 'result', 'status'
    ];

    /**
     * @var array
     */
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

    /**
     * @return MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }
}