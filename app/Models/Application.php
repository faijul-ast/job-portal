<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'job_id','source','source_app_id',
        'candidate_email','candidate_name','candidate_phone','resume_url',
        'status','raw_payload',
    ];

    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
