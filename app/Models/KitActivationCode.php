<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KitActivationCode extends Model
{
    protected $fillable = [
        'code',
        'used_by',
        'status',
        'module_id',
        'generated_by',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'used_at' => 'datetime',
        ];
    }

    /**
     * Get the user who used this code
     */
    public function usedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    /**
     * Get the user who generated this code
     */
    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Get the module this code is associated with
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(TinkeringModule::class, 'module_id');
    }

    /**
     * Get the module user records for this code
     */
    public function moduleUsers(): HasMany
    {
        return $this->hasMany(ModuleUser::class, 'activation_code_id');
    }

    /**
     * Check if code is unused
     */
    public function isUnused(): bool
    {
        return $this->status === 'unused';
    }

    /**
     * Check if code is used
     */
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    /**
     * Check if code is blocked
     */
    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    /**
     * Mark code as used
     */
    public function markAsUsed(User $user): void
    {
        $this->update([
            'status' => 'used',
            'used_by' => $user->id,
            'used_at' => now(),
        ]);
    }

    /**
     * Mark code as blocked
     */
    public function markAsBlocked(): void
    {
        $this->update(['status' => 'blocked']);
    }
}
