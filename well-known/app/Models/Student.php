<?php

namespace App\Models;

use App\Traits\ActionTakenBy;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    use ActionTakenBy;

    protected $primary_key = 'id';
    protected $table = 'tbl_student';
    protected $fillable = [
    'school_id',
    'student_name',
    'profile',
    'email_id',
    'mobile',
    'address',
    'father_name',
    'father_image',
    'mother_name',
    'mother_image',
    'guardian_image',
    'dob',
    'class',
    'section',
    'session',
    'adm_no',
    'medium',
    'studen_signature',
    'employe_signature',
    'bus',
    'blood_group',
    'roll_no',
    'designation',
    'husband_name',
    'emp_id',
    'emp_name',
    'blank_1',
    'blank_2'
];
}
