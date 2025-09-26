<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleUser extends Model
{
    protected $table = 'module_user';
    
    protected $fillable = [
        'user_id',
        'module_id',
        'activation_code_id',
        'unlocked_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'unlocked_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user this record belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module this record belongs to
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(TinkeringModule::class, 'module_id');
    }

    /**
     * Get the activation code used for this unlock
     */
    public function activationCode(): BelongsTo
    {
        return $this->belongsTo(KitActivationCode::class, 'activation_code_id');
    }
}
