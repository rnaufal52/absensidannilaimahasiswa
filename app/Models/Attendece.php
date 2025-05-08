<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Attendece extends Model
{
    use HasUuids;
    protected $table = 'attendences';
    protected $primaryKey = 'attendence_id';
    protected $fillable = ['student_id','session_id','attendence_status'];
    public $timestamps = true;

    public function students()
    {
        return $this->belongsTo(Students::class,'student_id');
    }

    public function Sessions()
    {
        return $this->belongsTo(Session::class,'Session_id');
    }
}
