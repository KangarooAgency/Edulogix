@extends('backEnd.master')
@section('title') 
@lang('accounts.add_expense')
@endsection
@section('mainContent')
@php  $setting = app('school_info'); if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; } @endphp

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.add_expense') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard') </a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.add_expense')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($add_expense))
        @if(userPermission("add-expense-store"))
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('add-expense')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>

        @endif
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">

                            <h3 class="mb-30">
                                @if(isset($add_expense))
                                    @lang('accounts.edit_expense')
                                @else
                                    @lang('accounts.add_expense')
                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($add_expense))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true,  'route' => array('add-expense-update',@$add_expense->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data' , 'id' => 'add-expense-update']) }}
                        @else
                        @if(userPermission("add-expense-store"))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'add-expense',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-expense']) }}
                        @endif
                        @endif
                        
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name')  <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($add_expense)? $add_expense->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_expense)? $add_expense->id: ''}}">
                                          
                                            
                                             @if (@$errors->has('name'))
                                            <span class="text-danger" >
                                                <strong>{{ @$errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                 <div class="row  mt-15">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">@lang('accounts.a_c_Head') <span class="text-danger"> *</span></label>
                                        <select class="primary_select  form-control{{ @$errors->has('expense_head') ? ' is-invalid' : '' }}" name="expense_head">
                                            <option data-display="@lang('accounts.a_c_Head') *" value="">@lang('accounts.a_c_Head') *</option>
                                            @foreach($expense_heads as $expense_head)
                                                @if(isset($add_expense))
                                                <option value="{{@$expense_head->id}}"
                                                    {{@$add_expense->expense_head_id == @$expense_head->id? 'selected': ''}}>{{@$expense_head->head}}</option>
                                                @else
                                                <option value="{{@$expense_head->id}}" {{old('expense_head') == @$expense_head->id? 'selected': ''}}>{{@$expense_head->head}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                       @if ($errors->has('expense_head'))
                                        <span class="text-danger invalid-select" role="alert">
                                            <strong>{{ @$errors->first('expense_head') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">@lang('accounts.payment_method') <span class="text-danger"> *</span></label>
                                        <select class="primary_select  form-control{{ @$errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="payment_method">
                                            <option data-display="@lang('accounts.payment_method') *" value="">@lang('accounts.payment_method') *</option>
                                            @foreach($payment_methods as $payment_method)
                                            @if(isset($add_expense))
                                            <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}"
                                                {{@$add_expense->payment_method_id == @$payment_method->id? 'selected': ''}}>{{@$payment_method->method}}</option>
                                            @else
                                                <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}" {{old('payment_method') == @$payment_method->id? 'selected': ''}}>{{@$payment_method->method}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('payment_method'))
                                        <span class="text-danger invalid-select" role="alert">
                                            <strong>{{ @$errors->first('payment_method') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-15 d-none" id="bankAccount">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">@lang('accounts.bank_accounts') <span class="text-danger"> *</span></label>
                                        <select class="primary_select  form-control{{ @$errors->has('accounts') ? ' is-invalid' : '' }}" name="accounts">
                                            <option data-display="@lang('accounts.bank_accounts') *" value="">@lang('accounts.bank_accounts')  *</option>
                                            @foreach($bank_accounts as $bank_account)
                                            @if(isset($add_expense))
                                            <option value="{{@$bank_account->id}}"
                                                {{@$add_expense->account_id == @$bank_account->id? 'selected': ''}}>{{@$bank_account->account_name}} ({{@$bank_account->bank_name}})</option>
                                            @else
                                            <option value="{{@$bank_account->id}}">{{@$bank_account->account_name}} ({{@$bank_account->bank_name}})</option>
                                            @endif
                                            @endforeach
                                        </select> 
                                        @if ($errors->has('accounts'))
                                        <span class="text-danger invalid-select" role="alert">
                                            <strong>{{ @$errors->first('accounts') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>

                                <div class="row mt-15">
                                    
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('admin.date')<span></span></label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input class="primary_input_field  primary_input_field date form-control form-control{{ @$errors->has('date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                            placeholder="@lang('common.date') " name="date" value="{{isset($add_expense)? date('m/d/Y',strtotime($add_expense->date)) : date('m/d/Y')}}">
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
                                <div class="row  mt-15">
                                    <div class="col-lg-12">

                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.amount')  <span class="text-danger"> *</span></label>
                                            <input oninput="numberCheckWithDot(this)" class="primary_input_field form-control{{ @$errors->has('amount') ? ' is-invalid' : '' }}"
                                                type="text" name="amount" step="0.1" autocomplete="off" value="{{isset($add_expense)? $add_expense->amount:old('amount')}}">
                                           
                                            
                                            @if ($errors->has('amount'))
                                            <span class="text-danger" >
                                                <strong>{{ @$errors->first('amount') }}</strong>
                                            </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                     
                                    <div class="col-lg-12 mt-15">
                                        <div class="primary_input">
                                            <div class="primary_file_uploader">
                                                <input class="primary_input_field" type="text" id="placeholderInput" placeholder="{{isset($add_expense)? ($add_expense->file != ""? getFilePath3($add_expense->file): trans('common.file')) :  trans('common.file')}}"readonly
                                                >
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="browseFile">{{ __('common.browse') }}</label>
                                                    <input type="file" class="d-none" name="file" id="browseFile">
                                                </button>
                                            </div>
                                        </div>
                                        <code>(PDF,DOC,DOCX,JPG,JPEG,PNG,TXT are allowed for upload)</code>
                                        @if ($errors->has('file'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('file') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.description')  <span></span></label>
                                            <textarea class="primary_input_field form-control" cols="0" rows="4" name="description">{{isset($add_expense)? $add_expense->description: old('description')}}</textarea>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                  @php 
                                  $tooltip = "";
                                  if(userPermission("add-expense-store") || userPermission('add-expense-edit')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($add_expense))
                                                @lang('accounts.update_expense')
                                            @else
                                                @lang('accounts.save_expense')
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
                            <h3 class="mb-0">@lang('accounts.expense_list') </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <x-table>
                        <table id="table_id" class="table data-table" cellspacing="0" width="100%">

                            <thead>
                                
                                <tr>
                                    <th>Si </th>
                                    <th>@lang('common.name') </th>
                                    <th>@lang('accounts.payment_method') </th>
                                    <th>@lang('common.date') </th>
                                    <th>@lang('accounts.a_c_Head') </th>
                                    <th>@lang('accounts.amount') </th>
                                    <th>@lang('common.action') </th>
                                </tr>
                            </thead>

                            <tbody>
                                
                            </tbody>
                        </table>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

 {{-- delete expense modal  --}}
 <div class="modal fade admin-query" id="deleteExpenseModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('accounts.delete_item') </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete') </h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel') </button>
                     {{ Form::open(['route' => 'add-expense-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" value="">
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete') </button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@include('backEnd.partials.date_picker_css_js')
@push('script')
<script type="text/javascript">
    $(document).ready(function() {
     
   $('.data-table').DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: "{{route('ajaxExpenseList')}}",
                       data: { 
                            un_semester_label_id: $('#un_semester_label_id').val(), 
                            class: $('#class').val(), 
                            section: $('#section').val(), 
                            payment_date: $('#p_date').val(), 
                            approve_status: $('#status').val()
                        },
                       pages: "{{generalSetting()->ss_page_load}}" // number of pages to cache
                       
                   } ),
                   columns: [
                        {data: 'DT_RowIndex', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'payment_method.method', name: 'method'},
                        {data: 'date', name: 'date'},
                        {data: 'a_c_head.head', name: 'head'},
                        {data: 'amount', name: 'amount'},
                       {data: 'action', name: 'action',orderable: false, searchable: true},
                       
                    ],
                    bLengthChange: false,
                    bDestroy: true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: window.jsLang('quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>",
                        },
                    },
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "copyHtml5",
                        text: '<i class="fa fa-files-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('copy_table'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: window.jsLang('export_to_excel'),
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: window.jsLang('export_to_csv'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('export_to_pdf'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                        orientation: "landscape",
                        pageSize: "A4",
                        margin: [0, 0, 0, 12],
                        alignment: "center",
                        header: true,
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: "center",
                                image: "data:image/png;base64," + $("#logo_img").val(),
                            });
                        },
                    },
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: window.jsLang('print'),
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "colvis",
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ["colvisRestore"],
                    },
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });
        } );



        function deleteExpense(id){
            var modal = $('#deleteExpenseModal');
            modal.find('input[name=id]').val(id);
            modal.modal('show');
        }
</script>
@endpush