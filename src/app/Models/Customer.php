<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    protected $table = 'customer';

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
     * Scope to filter by cpf
     * @param Builder $query
     * @param string $cpf
     * @return Builder $query
     */
    public function scopeFilterByCpf(Builder $query, string $cpf) : Builder
    {
        return $query->where('cpf', $cpf);
    }

    /**
     * Get the user that owns the phone.
     */
    public function company()
    {
        return $this->belongsToMany('App\Models\Company');
    }
}
