<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasUuids;
    protected $table = 'session';
    protected $primaryKey = 'session_id';
    protected $fillable = ['session_topic','course_id','session_date'];
    public $timestamps = true;

    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
