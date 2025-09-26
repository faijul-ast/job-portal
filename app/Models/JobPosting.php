<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobPosting extends Model
{
    protected $table = 'job_postings';

    protected $fillable = [
        'title','slug','description','company_name',
        'street','city','state','postal_code','country',
        'employment_type','salary_min','salary_max','salary_currency','salary_period',
        'valid_through','is_public','is_remote','status',
    ];

    protected $casts = [
        'valid_through' => 'datetime',
        'is_public' => 'boolean',
        'is_remote' => 'boolean',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_public', true)
            ->where('status', 'published')
            ->where(function($qq){
                $qq->whereNull('valid_through')->orWhere('valid_through', '>=', now());
            });
    }

    public function publicUrl(): string
    {
        return route('job_postings.show', ['slug' => $this->slug]);
    }
}
