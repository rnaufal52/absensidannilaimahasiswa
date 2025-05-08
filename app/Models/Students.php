<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasUuids;
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    protected $fillable = ['student_name','NPM'];
    public $timestamps = true;

    public function grades()
    {
        return $this->hasMany(Grades::class,'grade_id');
    }

    public function attendences()
    {
        return $this->hasMany(Attendece::class,'attendence_id');
    }
}
