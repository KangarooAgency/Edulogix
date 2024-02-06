@extends('backEnd.master')
@section('title')
    @lang('fees::feesModule.fees_due')
@endsection
@section('mainContent')

    <style>
        table.dataTable thead .sorting_asc::after {
            top: 10px !important;
            left: 3px !important;
        }

        table.dataTable thead .sorting::after {
            top: 10px !important;
            left: 3px !important;
        }
    </style>

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('fees::feesModule.fees_due')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('fees::feesModule.fees')</a>
                    <a href="#">@lang('fees::feesModule.fees_due')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'route' => 'fees.search-due-fees', 'method' => 'POST']) }}
                        @include('fees::report._searchForm')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            @isset($fees_dues)
                <div class="row mt-80">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 search_hide_md">
                                <x-table>
                                    <table id="table_id" class="table " cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('student.admission_no')</th>
                                                <th>@lang('student.roll_no')</th>
                                                <th>@lang('common.name')</th>
                                                <th>@lang('fees::feesModule.due_date')</th>
                                                <th>@lang('fees::feesModule.amount') ({{ generalSetting()->currency_symbol }})</th>
                                                <th>@lang('fees::feesModule.paid') ({{ generalSetting()->currency_symbol }})</th>
                                                <th>@lang('fees::feesModule.waiver') ({{ generalSetting()->currency_symbol }})</th>
                                                <th>@lang('fees::feesModule.fine') ({{ generalSetting()->currency_symbol }})</th>
                                                <th>@lang('fees::feesModule.balance') ({{ generalSetting()->currency_symbol }})</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fees_dues as $fees_due)
                                                @php
                                                    $amount = $fees_due->Tamount;
                                                    $weaver = $fees_due->Tweaver;
                                                    $fine = $fees_due->Tfine;
                                                    $paid_amount = $fees_due->Tpaidamount;
                                                    $sub_total = $fees_due->Tsubtotal;
                                                    $balance = $sub_total - $paid_amount + $fine;
                                                @endphp
                                                @if ($balance != 0)
                                                    <tr>
                                                        <td>{{ @$fees_due->studentInfo->admission_no }}</td>
                                                        <td>{{ @$fees_due->recordDetail->roll_no }}</td>
                                                        <td>{{ @$fees_due->studentInfo->full_name }}</td>
                                                        <td>{{ dateConvert($fees_due->due_date) }}</td>
                                                        <td>{{ $amount }}</td>
                                                        <td>{{ $paid_amount }}</td>
                                                        <td>{{ $weaver }}</td>
                                                        <td>{{ $fine }}</td>
                                                        <td>{{ $balance }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.date_range_picker_css_js')
@push('script')
    <script type="text/javascript" src="{{ url('Modules\Fees\Resources\assets\js\app.js') }}"></script>
@endpush
