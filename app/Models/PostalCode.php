<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    protected $fillable = [
        'circlename',
        'regionname',
        'divisionname',
        'officename',
        'pincode',
        'officetype',
        'delivery',
        'district',
        'statename',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    /**
     * Scope to search by pincode
     */
    public function scopeByPincode($query, string $pincode)
    {
        return $query->where('pincode', $pincode);
    }

    /**
     * Scope to search by district
     */
    public function scopeByDistrict($query, string $district)
    {
        return $query->where('district', 'like', "%{$district}%");
    }

    /**
     * Scope to search by state
     */
    public function scopeByState($query, string $state)
    {
        return $query->where('statename', 'like', "%{$state}%");
    }
}
