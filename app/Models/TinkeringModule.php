<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TinkeringModule extends Model
{
    protected $fillable = [
        'module_name',
        'slug',
        'description',
        'focus_area',
        'suggested_age_group',
        'duration',
        'key_skills',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'key_skills' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($module) {
            if (empty($module->slug)) {
                $module->slug = Str::slug($module->module_name);
            }
        });

        static::updating(function ($module) {
            if ($module->isDirty('module_name') && empty($module->slug)) {
                $module->slug = Str::slug($module->module_name);
            }
        });
    }

    /**
     * Get the user who created this module
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the sub-activities for this module
     */
    public function subActivities(): HasMany
    {
        return $this->hasMany(TinkeringModuleSubActivity::class, 'tinkering_module_id')
            ->orderBy('order');
    }

    /**
     * Get the users who have unlocked this module
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'module_user', 'module_id', 'user_id')
            ->withPivot(['activation_code_id', 'unlocked_at', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Get the kit activation codes for this module
     */
    public function activationCodes(): HasMany
    {
        return $this->hasMany(KitActivationCode::class, 'module_id');
    }

    /**
     * Get the next available activation code for this module
     */
    public function getNextAvailableCode(): ?string
    {
        $availableCode = $this->activationCodes()
            ->where('status', 'unused')
            ->first();

        return $availableCode ? $availableCode->code : null;
    }

    /**
     * Check if module is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Activate the module
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the module
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
