<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TinkeringModuleSubActivity extends Model
{
    protected $fillable = [
        'tinkering_module_id',
        'title',
        'slug',
        'objective',
        'concept_focus',
        'materials_needed',
        'instructions',
        'circuit_diagram',
        'explanation',
        'video_link',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'materials_needed' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });

        static::updating(function ($activity) {
            if ($activity->isDirty('title') && empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });
    }

    /**
     * Get the module this sub-activity belongs to
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(TinkeringModule::class, 'tinkering_module_id');
    }

    /**
     * Get the checklists for this sub-activity
     */
    public function checklists(): HasMany
    {
        return $this->hasMany(ActivityChecklist::class, 'tinkering_module_sub_activity_id')
            ->orderBy('order');
    }

    /**
     * Get the user progress for this sub-activity
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserActivityProgress::class, 'sub_activity_id');
    }

    /**
     * Check if sub-activity is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Activate the sub-activity
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the sub-activity
     */
    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Get the route key name
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
