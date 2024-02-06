<?php

use App\SmExam;
use App\SmMarksGrade;
use App\SmResultStore;
use App\SmSchool;
use App\YearCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Saas\Events\InstituteRegistration;

if (config('app.app_sync')) {
    Route::get('/', 'LandingController@index')->name('/');
}

if (moduleStatusCheck('Saas')) {
    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}.' . config('app.short_url')], function ($routes) {
        require('tenant.php');
    });

    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}'], function ($routes) {
        require('tenant.php');
    });
}

Route::group(['middleware' => ['subdomain']], function ($routes) {
    require('tenant.php');
});

Route::get('migrate', function () {
    if(Auth::check() && Auth::id() == 1){
        \Artisan::call('migrate', ['--force' => true]);
        \Brian2694\Toastr\Facades\Toastr::success('Migration run successfully');
        return redirect()->to(url('/admin-dashboard'));
    }
    abort(404);
});


Route::get('e', function (){
    \App\SmMarkStore::truncate();
    SmResultStore::truncate();
    $exams = SmExam::with('GetExamSetup')->get();
    $studentRecords = \App\Models\StudentRecord::with('studentDetail')->get();
    foreach($exams as $exam){
        $eligibleRecords = $studentRecords->where('class_id', $exam->class_id)->where('section_id', $exam->section_id)->where('academic_id', $exam->academic_id);

        foreach($eligibleRecords as $record){
            $total_marks_persubject = 0;
            foreach($exam->GetExamSetup as $setup){
                $setup_mark = random_int(0, $setup->exam_mark );
                $total_marks_persubject += $setup_mark;
                $markStore = new \App\SmMarkStore();
                $markStore->student_roll_no = $record->roll_no;
                $markStore->student_addmission_no = $record->studentDetail->admission_no;
                $markStore->total_marks = $setup_mark;
                $markStore->is_absent = 1;
                $markStore->teacher_remarks = 'teacher_remarks';
                $markStore->subject_id = $exam->subject_id;
                $markStore->exam_term_id = $exam->exam_type_id;
                $markStore->exam_setup_id = $setup->id;
                $markStore->student_id = $record->student_id;
                $markStore->class_id = $record->class_id;
                $markStore->section_id = $record->section_id;
                $markStore->student_record_id = $record->id;
                $markStore->save();
            }
            $mark_by_persentage = subjectPercentageMark($total_marks_persubject, $exam->exam_mark);
            $mark_grade = SmMarksGrade::where([
                ['percent_from', '<=', $mark_by_persentage],
                ['percent_upto', '>=', $mark_by_persentage]])
                ->where('academic_id', $exam->academic_id)
                ->where('school_id', $exam->school_id)
                ->first();
            $result_record = new SmResultStore();
            $result_record->student_roll_no = $record->roll_no;
            $result_record->student_addmission_no = $record->studentDetail->admission_no;
            $result_record->exam_type_id = $exam->exam_type_id;
            $result_record->student_id = $record->student_id;
            $result_record->class_id = $record->class_id;
            $result_record->section_id = $record->section_id;
            $result_record->academic_id = $record->academic_id;
            $result_record->student_record_id = $record->id;
            $result_record->subject_id = $exam->subject_id;

            $result_record->total_marks            =   $total_marks_persubject;
            $result_record->total_gpa_point        =   @$mark_grade->gpa;
            $result_record->total_gpa_grade        =   @$mark_grade->grade_name;
            $result_record->teacher_remarks        =   'teacher_remarks';
            $result_record->school_id = $exam->school_id;
            $result_record->save();
        }
    }
});
