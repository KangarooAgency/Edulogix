@extends('backEnd.master')
@section('title')
    @lang('admin.phone_call_log')
@endsection

@section('mainContent')
    <style>
        .check_box_table table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child::before,
        .check_box_table table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child::before {
            top: 30px !important;
    }
    </style>
    <section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('admin.phone_call_log')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('admin.admin_section')</a>
                    <a href="#">@lang('admin.phone_call_log')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($phone_call_log))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{ route('phone-call') }}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @if (isset($phone_call_log))
                                        @lang('admin.edit_phone_call')
                                    @else
                                        @lang('admin.add_phone_call')
                                    @endif

                                </h3>
                            </div>
                            @if (isset($phone_call_log))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['phone-call_update', @$phone_call_log->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('phone-call-store'))
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'phone-call', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">

                                        <div class="col">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('common.name')</label>

                                                <input
                                                    class="primary_input_field form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text" name="name"
                                                    value="{{ isset($phone_call_log) ? $phone_call_log->name : old('name') }}">

                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ @$errors->first('name') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <input type="hidden" name="id"
                                        value="{{ isset($phone_call_log) ? $phone_call_log->id : '' }}">
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('admin.phone') <span
                                                        class="text-danger"> *</span></label>
                                                <input oninput="phoneCheck(this)"
                                                    class="primary_input_field form-control{{ @$errors->has('phone') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="tel" name="phone"
                                                    value="{{ isset($phone_call_log) ? $phone_call_log->phone : old('phone') }}">


                                                @if ($errors->has('phone'))
                                                    <span class="text-danger">{{ @$errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('common.date')
                                                    <span></span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input
                                                                    class="primary_input_field  primary_input_field date form-control"
                                                                    id="startDate" type="text" name="date"
                                                                    value="{{ isset($phone_call_log) ? $phone_call_log->date : date('m/d/Y') }}"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="btn-date" data-id="#startDate" type="button">
                                                            <label class="m-0 p-0" for="startDate">
                                                                <i class="ti-calendar" id="start-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('admin.follow_up_date')
                                                    <span></span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input
                                                                    class="primary_input_field  primary_input_field date form-control{{ @$errors->has('follow_up_date') ? ' is-invalid' : '' }}"
                                                                    id="follow_up_date" type="text" name="follow_up_date"
                                                                    value="{{ isset($phone_call_log) ? $phone_call_log->next_follow_up_date : date('m/d/Y') }}"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="btn-date" data-id="#follow_up_date" type="button">
                                                            <label class="m-0 p-0" for="follow_up_date">
                                                                <i class="ti-calendar" id="start-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('follow_up_date') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('admin.call_duration')</label>
                                                <input
                                                    class="primary_input_field form-control{{ @$errors->has('call_duration') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text" name="call_duration"
                                                    value="{{ isset($phone_call_log) ? $phone_call_log->call_duration : old('call_duration') }}">


                                                @if ($errors->has('call_duration'))
                                                    <span
                                                        class="text-danger">{{ @$errors->first('call_duration') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('admin.description')
                                                    <span></span></label>
                                                @isset($phone_call_log)
                                                    <textarea class="primary_input_field form-control" cols="0" rows="4" name="description"> {{ @$phone_call_log->description }}</textarea>
                                                @else
                                                    <textarea class="primary_input_field form-control" cols="0" rows="4" name="description">{{ old('description') }}</textarea>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-30">
                                            <div class="col-lg-12 d-flex">
                                                <p class="text-uppercase fw-500 mb-10">@lang('common.type')</p>
                                                <div class=" radio-btn-flex ml-20">
                                                    @if (isset($phone_call_log))
                                                        <div class="mr-30 mb-4">
                                                            <input type="radio" name="call_type" id="relationFather"
                                                                value="I"
                                                                {{ @$phone_call_log->call_type == 'I' ? 'checked' : '' }}
                                                                class="common-radio relationButton">
                                                            <label for="relationFather">@lang('admin.incoming')</label>
                                                        </div><br>
                                                        <div class="mr-30 mb-2">
                                                            <input type="radio" name="call_type" id="relationMother"
                                                                value="O"
                                                                {{ @$phone_call_log->call_type == 'O' ? 'checked' : '' }}
                                                                class="common-radio relationButton">
                                                            <label for="relationMother">@lang('admin.outgoing')</label>
                                                        </div>
                                                    @else
                                                        <div class="mr-30 mb-4">
                                                            <input type="radio" name="call_type" id="relationFather"
                                                                value="I" class="common-radio relationButton" checked>
                                                            <label for="relationFather">@lang('admin.incoming')</label>
                                                        </div>
                                                        <div class="mr-30 mb-2">
                                                            <input type="radio" name="call_type" id="relationMother"
                                                                value="O" class="common-radio relationButton">
                                                            <label for="relationMother">@lang('admin.outgoing')</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $tooltip = '';
                                            if (userPermission('phone-call-store')) {
                                                $tooltip = '';
                                            } else {
                                                $tooltip = 'You have no permission to add';
                                            }
                                        @endphp
                                        <div class="row mt-40">
                                            <div class="col-lg-12 text-center">
                                                <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                    title="{{ @$tooltip }}">
                                                    <span class="ti-check"></span>
                                                    @if (isset($phone_call_log))
                                                        @lang('admin.update_phone_call')
                                                    @else
                                                        @lang('admin.save_phone_call')
                                                    @endif

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">@lang('admin.phone_call_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.name')</th>
                                                <th>@lang('common.phone')</th>
                                                <th>@lang('common.date')</th>
                                                <th>@lang('admin.follow_up_date')</th>
                                                <th>@lang('admin.call_duration')</th>
                                                <th>@lang('common.description')</th>
                                                <th>@lang('admin.call_type')</th>
                                                <th>@lang('common.actions')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($phone_call_logs as $phone_call_log)
                                                <tr>
                                                    <td>{{ @$phone_call_log->name }}</td>
                                                    <td>{{ @$phone_call_log->phone }}</td>
                                                    <td>
                                                        {{ @$phone_call_log->date != '' ? dateConvert(@$phone_call_log->date) : '' }}
                                                    </td>
                                                    <td>
                                                        {{ @$phone_call_log->next_follow_up_date != '' ? dateConvert(@$phone_call_log->next_follow_up_date) : '' }}
                                                    </td>
                                                    <td>{{ @$phone_call_log->call_duration }}</td>
                                                    <td>{{ @$phone_call_log->description }}</td>
                                                    <td>{{ trans('admin.' . ($phone_call_log->call_type == 'I' ? 'incoming' : 'outgoing')) }}
                                                    </td>
                                                    <td>
                                                        {{-- <div class="dropdown">
                                                            <button type="button" class="btn dropdown-toggle"
                                                                data-toggle="dropdown">
                                                                @lang('common.select')
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right"> --}}
                                                        <x-drop-down>
                                                            @if (userPermission('phone-call_edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('phone-call_edit', @$phone_call_log->id) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('phone-call_delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteCallLogModal{{ @$phone_call_log->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                        {{-- </div>
                                                        </div> --}}
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteCallLogModal{{ @$phone_call_log->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('admin.delete_phone_call')</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                </div>
                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal">@lang('common.cancel')</button>
                                                                    {{ Form::open(['route' => ['phone-call_delete', @$phone_call_log->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                    <button class="primary-btn fix-gr-bg"
                                                                        type="submit">@lang('common.delete')</button>
                                                                    {{ Form::close() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @include('backEnd.partials.data_table_js')
    @include('backEnd.partials.date_picker_css_js')
