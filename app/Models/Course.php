<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasUuids;
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $fillable = ['course_name'];
    public $timestamps = true;

    // todo: relasi ke grades dan session
    public function grades()
    {
    }

    public function session()
    {
        return $this->hasMany(Session::class,'session_id');
    }
}
