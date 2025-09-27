<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivityProgress extends Model
{
    protected $fillable = [
        'user_id',
        'sub_activity_id',
        'completed_checklist_items',
        'progress_percent',
        'last_viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_checklist_items' => 'array',
            'progress_percent' => 'decimal:2',
            'last_viewed_at' => 'datetime',
        ];
    }

    /**
     * Get the user this progress belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sub-activity this progress belongs to
     */
    public function subActivity(): BelongsTo
    {
        return $this->belongsTo(TinkeringModuleSubActivity::class, 'sub_activity_id');
    }

    /**
     * Update progress based on completed checklist items
     */
    public function updateProgress(array $completedItems, int $totalItems): void
    {
        $progressPercent = $totalItems > 0 ? (count($completedItems) / $totalItems) * 100 : 0;
        
        $this->update([
            'completed_checklist_items' => $completedItems,
            'progress_percent' => round($progressPercent, 2),
            'last_viewed_at' => now(),
        ]);
    }

    /**
     * Check if activity is completed
     */
    public function isCompleted(): bool
    {
        return $this->progress_percent >= 100;
    }
}
