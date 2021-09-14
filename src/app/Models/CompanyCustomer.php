<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompanyCustomer extends Model
{
    protected $table = 'company_customer';

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
     * Scope to filter by name
     * @param Builder $query
     * @param string $name
     * @return Builder $query
     */
    public function scopeFilterByName(Builder $query, string $name) : Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Scope to filter by state_id
     * @param Builder $query
     * @param ?string $state_id
     * @return Builder $query
     */
    public function scopeFilterByStateId(Builder $query, ?string $state_id) : Builder
    {
        if (!empty($state_id)) {
            $query->where('state_id', $state_id);
        }

        return $query;
    }

    /**
     * Get the user that owns the phone.
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }
}
