<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    use HasUuids;
    protected $table = 'grades';
    protected $primaryKey = 'grade_id';
    protected $fillable = ['student_id','course_id','grade_score','grade_symbol'];
    public $timestamps = true;

    public function students()
    {
        return $this->belongsTo(Students::class,'student_id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
