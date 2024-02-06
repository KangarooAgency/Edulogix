@extends('backEnd.master')
@section('title') 
@lang('accounts.bank_account')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.bank_account')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.bank_account')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($bank_account))
            @if(userPermission("bank-account-store"))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('bank-account')}}" class="primary-btn small fix-gr-bg">
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
                                @if(isset($bank_account))
                                    @lang('accounts.edit_bank_account')
                                @else
                                    @lang('accounts.add_bank_account')
                                @endif
                            </h3>
                        </div>
                        @if(isset($bank_account))
                            {{ Form::open(['class' => 'form-horizontal', 'route' => array('bank-account-update',@$bank_account->id), 'method' => 'PUT']) }}
                        @else
                            @if(userPermission("bank-account-store"))
                                {{ Form::open(['class' => 'form-horizontal', 'route' => 'bank-account', 'method' => 'POST']) }}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.bank_name') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ @$errors->has('bank_name') ? ' is-invalid' : '' }}" type="text" name="bank_name" autocomplete="off" value="{{isset($bank_account)? $bank_account->bank_name : old('bank_name')}}">
                                           
                                            
                                            @if ($errors->has('bank_name'))
                                                <span class="text-danger" >
                                                    <strong>{{ @$errors->first('bank_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.account_name') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ @$errors->has('account_name') ? ' is-invalid' : '' }}" type="text" name="account_name" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_name:old('account_name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_income)? $add_income->id: ''}}">
                                            
                                            
                                            @if ($errors->has('account_name'))
                                                <span class="text-danger" >
                                                    <strong>{{ @$errors->first('account_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.account_number') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ @$errors->has('account_number') ? ' is-invalid' : '' }}" type="tel" name="account_number" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_number:old('account_number')}}">
                                           
                                            
                                            @if ($errors->has('account_number'))
                                                <span class="text-danger" >
                                                    <strong>{{ @$errors->first('account_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.account_type')</label>
                                            <input class="primary_input_field form-control{{ @$errors->has('account_type') ? ' is-invalid' : '' }}" type="text" name="account_type" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_type:old('account_type')}}">
                                          
                                            
                                            @if ($errors->has('account_type'))
                                                <span class="text-danger" >
                                                    <strong>{{ @$errors->first('account_type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row  mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('accounts.opening_balance')<span class="text-danger"> *</span></label>
                                            <input oninput="numberCheckWithDot(this)" class="primary_input_field form-control{{ @$errors->has('opening_balance') ? ' is-invalid' : '' }}" type="text" step="0.1" name="opening_balance" autocomplete="off" value="{{isset($bank_account)? $bank_account->opening_balance:old('opening_balance')}}">
                                            <input type="hidden" name="id" value="{{isset($bank_account)? $bank_account->id: ''}}">
                                           
                                            
                                            @if ($errors->has('opening_balance'))
                                                <span class="text-danger" >
                                                    <strong>{{ @$errors->first('opening_balance') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-15">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.note') <span></span></label>
                                            <textarea class="primary_input_field form-control" cols="0" rows="4" name="note">{{isset($bank_account)? $bank_account->note: old('note')}}</textarea>
                                           
                                            
                                        </div>
                                    </div>
                                </div>

                            	@php 
                                  $tooltip = "";
                                  if(userPermission("bank-account-store")){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp

                                <div class="row mt-25">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($bank_account))
                                                @lang('accounts.update_account')
                                            @else
                                                @lang('accounts.save_account')
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
                            <h3 class="mb-0">@lang('accounts.bank_account_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <x-table>
                        <table id="table_id" class="table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('accounts.bank_name')</th>
                                    <th>@lang('accounts.account_name')</th>
                                    <th>@lang('accounts.opening_balance')</th>
                                    <th>@lang('accounts.current_balance')</th>
                                    <th>@lang('common.note')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bank_accounts as $bank_account)
                                <tr>
                                    <td>{{@$bank_account->bank_name}}</td>
                                    <td>{{@$bank_account->account_name}}</td>
                                    <td>{{currency_format(@$bank_account->opening_balance)}}</td>
                                    <td>{{currency_format(@$bank_account->current_balance)}}</td>
                                    <td>{{@$bank_account->note}}</td>
                                    <td>
                                        <x-drop-down>
                                               <!-- @if(userPermission('bank-account-edit'))
                                                <a class="dropdown-item" href="{{route('bank-account-edit', [$bank_account->id])}}">@lang('common.edit')</a>
                                                @endif -->
                                                @if(userPermission('bank-transaction'))
                                                    <a class="dropdown-item" href="{{route('bank-transaction',[$bank_account->id])}}">@lang('accounts.transaction')</a>
                                                @endif
                                                @if(userPermission("bank-account-delete"))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteBankAccountModal{{@$bank_account->id}}"
                                                    href="#">@lang('common.delete')</a>
                                                @endif
                                        </x-drop-down>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteBankAccountModal{{@$bank_account->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('accounts.delete_bank_account')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                     {{ Form::open(['route' => array('bank-account-delete',@$bank_account->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
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