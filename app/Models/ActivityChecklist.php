<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityChecklist extends Model
{
    protected $fillable = [
        'tinkering_module_sub_activity_id',
        'item',
        'order',
    ];

    /**
     * Get the sub-activity this checklist belongs to
     */
    public function subActivity(): BelongsTo
    {
        return $this->belongsTo(TinkeringModuleSubActivity::class, 'tinkering_module_sub_activity_id');
    }
}
