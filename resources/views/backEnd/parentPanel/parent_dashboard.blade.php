@extends('backEnd.master')
@section('title')
    @lang('parent.parent_dashboard')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/css/fullcalendar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/core/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/daygrid/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/timegrid/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/list/main.css') }}" />
@endpush
@section('mainContent')
    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="main-title">
                        <h3 class="mb-20">@lang('parent.my_children')</h3>
                    </div>
                </div>
            </div>

            {{-- <div class="row"> --}}
            @foreach ($my_childrens as $children)
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Start Student Meta Information -->
                        <div class="main-title">
                            <h3 class="mb-20"><strong> {{ $children->full_name }}</strong></h3>
                        </div>

                        @php
                            $student_detail = $children;

                            $issueBooks = $student_detail->bookIssue;

                            $homeworkLists = 0;
                            $totalSubjects = 0;
                            $totalOnlineExams = 0;
                            $totalTeachers = 0;
                            $totalExams = 0;

                            foreach ($student_detail->studentRecords as $record) {
                                $homeworkLists += $record->getHomeWorkAttribute()->count();
                                $totalSubjects += $record->getAssignSubjectAttribute()->count();
                                $totalTeachers += $record->getStudentTeacherAttribute()->count();
                                $totalOnlineExams += $record->getOnlineExamAttribute()->count();
                                $totalExams += $record->examSchedule()->count();
                            }

                            $attendances = $student_detail->studentAttendances->where('academic_id', generalSetting()->session_id);
                            
                        @endphp
                    </div>
                </div>
                <div class="row">
                    @if (userPermission('parent-dashboard-subject'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_subjects', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('common.subject')</h3>
                                            <p class="mb-0">@lang('parent.total_subject')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                                {{ $totalSubjects }}

                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-notice'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_noticeboard') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.notice')</h3>
                                            <p class="mb-0">@lang('parent.total_notice')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($totalNotices))
                                                {{ count($totalNotices) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-exam'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_exam_schedule', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.exam')</h3>
                                            <p class="mb-0">@lang('parent.total_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                                {{ $totalExams }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-exam'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_online_examination', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.online_exam')</h3>
                                            <p class="mb-0">@lang('parent.total_online_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                                {{ $totalOnlineExams }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-teacher'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_teacher_list', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.teachers')</h3>
                                            <p class="mb-0">@lang('parent.total_teachers')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                                {{ $totalTeachers }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-issued-books'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_library') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.issued_book')</h3>
                                            <p class="mb-0">@lang('parent.total_issued_book')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($issueBooks))
                                                {{ count($issueBooks) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-pending-homeworks'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_homework', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.pending_home_work')</h3>
                                            <p class="mb-0">@lang('parent.total_pending_home_work')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($homeworkLists))
                                                {{ $homeworkLists }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-attendance-in-current-month'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_attendance', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.attendance_in_current_month')</h3>
                                            <p class="mb-0">@lang('parent.total_attendance_in_current_month')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($attendances))
                                                {{ count($attendances) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                </div>
                {{-- </div> --}}
                <br>
            @endforeach

            @if (userPermission('parent-dashboard-calendar'))
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('parent.calendar')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class='common-calendar'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span
                            class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('public/backEnd/') }}/vendors/js/fullcalendar.min.js"></script>
    <script src="{{ asset('public/backEnd/vendors/js/fullcalendar-locale-all.js') }}"></script>

    <script type="text/javascript">
        /*-------------------------------------------------------------------------------
               Full Calendar Js
            -------------------------------------------------------------------------------*/
        if ($('.common-calendar').length) {
            $('.common-calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#image').attr('src', event.url);
                    $('#fullCalModal').modal();
                    return false;
                },
                height: 650,
                events: <?php echo json_encode($calendar_events); ?>
            });
        }
    </script>
@endpush
