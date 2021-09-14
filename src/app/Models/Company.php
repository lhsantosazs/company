<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Company extends Model
{
    protected $table = 'company';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Scope to filter by id
     * @param Builder $query
     * @param ?string $id
     * @return Builder $query
     */
    public function scopeFilterById(Builder $query, ?string $id) : Builder
    {
        if (!empty($id)) {
            $query->where('id', $id);
        }

        return $query;
    }

    /**
     * Scope to filter by cnpj
     * @param Builder $query
     * @param string $cnpj
     * @return Builder $query
     */
    public function scopeFilterByCnpj(Builder $query, string $cnpj) : Builder
    {
        return $query->where('cnpj', $cnpj);
    }

    /**
     * Get the customers.
     */
    public function customers()
    {
        return $this->belongsToMany('App\Models\Customer');
    }

    /**
     * Get the employees.
     */
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee');
    }
    
}
