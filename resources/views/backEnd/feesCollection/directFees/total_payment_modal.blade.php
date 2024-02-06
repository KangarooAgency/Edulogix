
<style type="text/css">
      #bank-area, #cheque-area{
          display: none;
      }
      .primary_input_field ~ label {
      top: -15px;
      }
  </style>
  
  <div class="container-fluid">
    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3 )
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-direct-fees-total-payment-submit',
        'method' => 'POST', 'id'=>'addFeesPayment', 'enctype' => 'multipart/form-data', 'name' => 'myForm','onsubmit' => "return validateFormFees()"]) }}
    @else 
      {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'direct-fees-total-payment-submit',
                          'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'myForm']) }}
    @endif 
          <div class="row">
              <div class="col-lg-12">
                  <div class="row mt-25">
                      <div class="col-lg-6">
                        <div class="primary_datepicker_input">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('common.date')</label>
                                        <input class="primary_input_field  primary_input_field date form-control form-control" id="startDate" type="text"
                                            name="date" value="{{date('m/d/Y')}}" readonly>
                                            <button class="btn-date" style="top: 70% !important;" data-id="#date_of_birth" type="button">
                                                <label class="m-0 p-0" for="date_of_birth">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </label>
                                            </button>
                                            
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="col-lg-12" id="sibling_class_div">
                            <div class="primary_input">
                              <label class="primary_input_label" for="">@lang('fees.amount') <span class="text-danger"> *</span> </label>
                                <input class="primary_input_field form-control" type="number" min="1" max="{{$balace_amount}}" name="request_amount" value="{{$balace_amount}}" id="amount" required>
                                <span class=" text-danger" role="alert" id="amount_error"></span>
                            </div>
                        </div>
                      </div>
                  </div>
  
                  <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                  <input type="hidden" name="installment_id" id="installment_id" value="{{@$installment_id}}">
                  <input type="hidden" name="real_amount" id="real_amount" value="{{$balace_amount}}">
                  <input type="hidden" id="student_id" name="student_id" value="{{$student_id}}">
                  <input type="hidden" name="fees_discount_id" value="{{@$discounts->fees_discount_id}}">
                  <input type="hidden" name="applied_amount" value="{{@$discounts->applied_amount}}">
                  <input type="hidden" name="record_id" value="{{@$record_id}}">
  
                  <div class="row mt-25">
                      <div class="col-lg-6 d-none">
                          <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('fees.discount') <span></span> </label>
                              <input oninput="numberCheckWithDot(this)" class="primary_input_field form-control" type="text" name="discount_amount" id="discount_amount" value="0">
                             
                              
                          </div>
                      </div>

                  </div>
                  <div class="row mt-25" id="fine_title" style="display:none">
                     
                      <div class="col-lg-12">
                          <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('fees.fine_title') <span></span> </label>
                              <input class="primary_input_field form-control"  type="text" name="fine_title" >
                             
                              
                          </div>
                      </div>
                  </div>
                  <script>
                  function checkFine(){
                      var fine_amount=document.getElementById("fine_amount").value;
                      var fine_title=document.getElementById("fine_title");
                  if (fine_amount>0) {
                      fine_title.style.display = "block";
                  } else {
                      fine_title.style.display = "none";
                  }
                  }
                  </script>
                  <div class="row mt-50">
                      <div class="col-lg-3">
                          <p class="text-uppercase fw-500 mb-10">@lang('fees.payment_mode') *</p>
                      </div>
                      <div class="col-lg-6">
                              <div class="d-flex radio-btn-flex ml-40">
                                @if(auth()->user()->role_id != 2 && auth()->user()->role_id != 3)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="cash" value="cash" class="common-radio relationButton" onclick="relationButton('cash')" checked>
                                      <label for="cash">@lang('fees.cash') </label>
                                  </div>
                                  @endif 
                                  
                                  @if(@$method['bank_info']->active_status == 1)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="bank" value="bank" class="common-radio relationButton" onclick="relationButton('Bk')">
                                      <label for="bank">@lang('fees.bank')</label>
                                  </div>
                                  @endif
                                  @if(@$method['cheque_info']->active_status == 1)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="cheque" value="cheque" class="common-radio relationButton"  onclick="relationButton('Cq')">
                                      <label for="cheque">@lang('fees.cheque')</label>
                                  </div>
                                  @endif

                                @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3)    
                                  @if(@$data['PayPal']->active_status == 1)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="Paypal" value="PayPal" class="common-radio relationButton"  onclick="relationButton('PayPal')" >
                                      <label for="Paypal">@lang('fees.Paypal')</label>
                                  </div>
                                  @endif
    
                                  @if(@$data['Stripe']->active_status == 1)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="Stripe" value="Stripe" class="common-radio relationButton"  onclick="relationButton('Stripe')" >
                                      <label for="Stripe">@lang('fees.Stripe')</label>
                                  </div>
                                  @endif
    
                                  @if(@$data['Paystack']->active_status == 1)
                                  <div class="mr-30">
                                      <input type="radio" name="payment_mode" id="Paystack" value="Paystack" class="common-radio relationButton"  onclick="relationButton('Paystack')" >
                                      <label for="Paystack">@lang('fees.Paystack')</label>
                                  </div>
                                  @endif
                               
                                @endif 

                              </div>
                      </div>
                  </div>
                  <div class="row mt-30 text-black text-bold" id="serviceChargeArea"></div>
                  <div class="row mt-50" id="feesBankPayment">
                      <div class="col-lg-3">
                          <p class="text-uppercase fw-500 mb-10">@lang('fees.select_bank')</p>
                      </div>
                      <div class="col-lg-9">
                          <div class="primary_input">
                              <select class="primary_select form-control bb{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" name="bank_id">
                              @if(isset($banks))
                              @foreach($banks as $key=>$value)
                              <option value="{{$value->id}}">{{$value->bank_name}}</option>
                              @endforeach
                              @endif
                              </select>
                              
                              @if ($errors->has('bank_id'))
                              <span class="text-danger invalid-select" role="alert">
                                  <strong>{{$errors->first('bank_id')}}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                  </div>
  
                 {{--  Start Bank and cheque info --}}
                 <div class="row" >
                  <div class="col-md-6 bank-details" id="bank-area">
                      <strong>{!!$data['bank_info']->bank_details!!}</strong>
                  </div>
                  <div class="col-md-6 cheque-details" id="cheque-area">
                      <strong>{!!$data['cheque_info']->cheque_details!!}</strong>
                  </div>
                 </div>
                 {{--  End Bank and cheque info --}}
                  <div class="row mt-25" id="noteArea">
                      <div class="col-lg-12" id="sibling_name_div">
                          <div class="primary_input mt-20">
                            <label class="primary_input_label" for="">@lang('common.note') </label>
                              <textarea class="primary_input_field form-control" cols="0" rows="3" name="note" id="note"></textarea>
                          </div>
                      </div>
  
                      
                  </div>
                  <div class="row no-gutters input-right-icon mt-35" id="fileupArea">
                          <div class="col">
                              <div class="primary_input">
                                  <input class="primary_input_field form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" 
                                  id="placeholderInput" 
                                  type="text"
                                  placeholder="{{isset($visitor)? ($visitor->slip != ""? getFilePath3($visitor->slip):'File Name'):'File Name'}}"
                                  readonly>
                                  
  
                                  @if ($errors->has('file'))
                                      <span class="text-danger d-block" >
                                          <strong>{{ @$errors->first('file') }}
                                      </span>
                              @endif
                              
                              </div>
                          </div>
                          <div class="col-auto">
                              <button class="primary-btn-small-input" type="button">
                                  <label class="primary-btn small fix-gr-bg"
                                         for="browseFile">@lang('common.browse')</label>
                                  <input type="file" class="d-none" id="browseFile" name="slip">
                              </button>
                          </div>
                  </div>

                  {{-- stripe payment card option here  --}}
                    <div class="row mt-25" id="stripePaymentArea" style="display: none">
                        <div class="col-lg-12">
                            <div class="row">                                              
                                <div class="col-lg-6 mt-20">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.name_on_card') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control{{ $errors->has('name_on_card') ? ' is-invalid' : '' }}"
                                            type="text" name="name_on_card" autocomplete="off"
                                            value="">
                                        @if ($errors->has('name_on_card'))
                                            <span class="text-danger"
                                                role="alert"> {{ $errors->first('name_on_card') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-20">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.card_number') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control{{ $errors->has('card-number') ? ' is-invalid' : '' }} card-number"
                                            type="text" name="card-number" autocomplete="off"
                                            value="">
                                        
                                        
                                        @if ($errors->has('card-number'))
                                            <span class="text-danger"
                                                role="alert"> {{ $errors->first('card-number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">                                              
                                <div class="col-lg-4 mt-20">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.cvc') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-cvc" type="text" name="card-cvc"
                                            autocomplete="off" value="">
                                        
                                        
                                        @if ($errors->has('card-cvc'))
                                            <span class="text-danger"
                                                role="alert"> {{ $errors->first('card-cvc') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-20">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.expiration_month') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-expiry-month" type="text"
                                            name="card-expiry-month" autocomplete="off"
                                            value="">
                                    
                                        
                                        @if ($errors->has('card-expiry-month'))
                                            <span class="text-danger"
                                                role="alert"> {{ $errors->first('card-expiry-month') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-20">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('accounts.expiration_year') <span class="text-danger"> *</span> </label>
                                        <input class="primary_input_field form-control card-expiry-year" type="text"
                                            name="card-expiry-year" autocomplete="off"
                                            value="">
                                    
                                        
                                        @if ($errors->has('card-expiry-year'))
                                            <span class="text-danger"
                                                role="alert"> {{ $errors->first('card-expiry-year') }}</span>
                                        @endif
                                    </div>                            
                                </div> 
                            </div>
                        </div>
                    </div>
              </div>

              <div class="row mt-25" id="stripePaymentArea" style="display: none">
                <div class="col-lg-12">
                     <div class="row">                                              
                        <div class="col-lg-6 mt-20">
                            <div class="primary_input">
                                <label  for="">@lang('accounts.name_on_card') <span class="text-danger"> *</span> </label>
                                <input class="primary-input form-control{{ $errors->has('name_on_card') ? ' is-invalid' : '' }}"
                                       type="text" name="name_on_card" autocomplete="off"
                                       value="">
                                @if ($errors->has('name_on_card'))
                                    <span class="text-danger"
                                          role="alert"> {{ $errors->first('name_on_card') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-20">
                            <div class="primary_input">
                                <label  for="">@lang('accounts.card_number') <span class="text-danger"> *</span> </label>
                                <input class="primary-input form-control{{ $errors->has('card-number') ? ' is-invalid' : '' }} card-number"
                                       type="text" name="card-number" autocomplete="off"
                                       value="">
                                
                                
                                @if ($errors->has('card-number'))
                                    <span class="text-danger"
                                          role="alert"> {{ $errors->first('card-number') }}</span>
                                @endif
                            </div>
                        </div>
                     </div>
                    <div class="row mt-20">                                              
                        <div class="col-lg-4 mt-20">
                            <div class="primary_input">
                                <label class="" for="">@lang('accounts.cvc') <span class="text-danger"> *</span> </label>
                                <input class="primary-input form-control card-cvc" type="text" name="card-cvc"
                                    autocomplete="off" value="123">
                                
                                
                                @if ($errors->has('card-cvc'))
                                    <span class="text-danger"
                                        role="alert"> {{ $errors->first('card-cvc') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 mt-20">
                            <div class="primary_input">
                                <label class="" for="">@lang('accounts.expiration_month') <span class="text-danger"> *</span> </label>
                                <input class="primary-input form-control card-expiry-month" type="text"
                                    name="card-expiry-month" autocomplete="off"
                                    value="12">
                               
                                
                                @if ($errors->has('card-expiry-month'))
                                    <span class="text-danger"
                                        role="alert"> {{ $errors->first('card-expiry-month') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 mt-20">
                            <div class="primary_input">
                                <label class="p" for="">@lang('accounts.expiration_year') <span class="text-danger"> *</span> </label>
                                <input class="primary-input form-control card-expiry-year" type="text"
                                    name="card-expiry-year" autocomplete="off"
                                    value="">
                               
                                
                                @if ($errors->has('card-expiry-year'))
                                    <span class="text-danger"
                                        role="alert"> {{ $errors->first('card-expiry-year') }}</span>
                                @endif
                            </div>                            
                        </div> 
                    </div>
                </div>
              </div>
  
              <div class="col-lg-12 text-center mt-40">
                  <div class="mt-40 d-flex justify-content-between">
                      <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
  
                      <button class="primary-btn fix-gr-bg submit" type="submit">@lang('common.save_information')</button>
                  </div>
              </div>
          </div>
      {{ Form::close() }}
  </div>
  @include('backEnd.partials.date_picker_css_js')
<script type="text/javascript">

  $(document).ready(function() 
    {
          $("#feesBankPayment").hide();
    });
  
   relationButton = (status) => {
              var cheque_area = document.getElementById("cheque-area");
              var bank_area = document.getElementById("bank-area");
              var amount = $("#amount").val();
              if(status == "Bk"){
                  cheque_area.style.display = "none";
                  bank_area.style.display = "block";
                  $("#feesBankPayment").show();
                  $("#stripePaymentArea").hide();
                  //$("#serviceChargeArea").hide();
                  serviceCharge(status, amount, 'payment_method');
              }else if(status == "Cq"){
                  cheque_area.style.display = "block";
                  bank_area.style.display = "none";
                  $('#noteArea').show();
                  $("#fileupArea").show();
                  $("#feesBankPayment").hide();
                  $("#stripePaymentArea").hide();
                 serviceCharge(status, amount, 'payment_method');
                  
              }
              else if(status == "PayPal"){
                  cheque_area.style.display = "none";
                  bank_area.style.display = "none";
                  $("#feesBankPayment").hide();
                  $('#noteArea').hide();
                  $("#fileupArea").hide();
                  $("#stripePaymentArea").hide();
                  serviceCharge(status, amount, 'payment_method');
              }
              else if(status == "Stripe"){
                  cheque_area.style.display = "none";
                  bank_area.style.display = "none";
                  $("#feesBankPayment").hide();
                  $('#noteArea').hide();
                  $("#fileupArea").hide();
                  $("#stripePaymentArea").show();
                  serviceCharge(status, amount, 'payment_method');
              }
              else if(status == "Paystack"){
                  cheque_area.style.display = "none";
                  bank_area.style.display = "none";
                  $("#feesBankPayment").hide();
                  $('#noteArea').hide();
                  $("#fileupArea").hide();
                  $("#stripePaymentArea").hide();
                  serviceCharge(status, amount, 'payment_method');
              }
          }

 function serviceCharge(gateway, amount, status)
    {
        var symbol = "{{ generalSetting()->currency_symbol }}";
        let amountTotal = parseFloat(amount);
        $.ajax({
            type:"GET",
            data : {gateway :gateway , amount : amountTotal, status : status},
            dataType:"JSON",
            url : "{{ route('gateway-service-charge') }}",
            success:function(data){              
                if(data.service_charge) {
                    $("#serviceChargeArea").show();
                    let total = parseFloat(amount) + parseFloat(data.service_charge_amount);                   
                    $('#serviceChargeArea').html('You Have to Pay service charge '+ data.service_charge + ' for ' + gateway + ' per transaction' + '. ' + 'Your payable amount with serivce charge : '+symbol+amount+'+'+symbol+ data.service_charge_amount +' = ' +symbol+parseFloat(total) );
                }else{
                    $("#serviceChargeArea").hide(); 
                }
            },
            error:function()
            {

            }
        })
    }

    $("#amount").on("input", function() {
        var amount = $(this).val(); 
        var gateway = $('input[name="payment_mode"]:checked').val();
        serviceCharge(gateway, amount, 'payment_method');
    });
  
      $("#search-icon").on("click", function() {
          $("#search").focus();
      });
  
      $("#start-date-icon").on("click", function() {
          $("#startDate").focus();
      });
  
      $("#end-date-icon").on("click", function() {
          $("#endDate").focus();
      });
  
      $(".primary_input_field.date").datepicker({
          autoclose: true,
          setDate: new Date(),
      });
      $(".primary_input_field.date").on("changeDate", function(ev) {
          // $(this).datepicker('hide');
          $(this).focus();
      });
  
      $(".primary_input_field.time").datetimepicker({
          format: "LT",
      });
  
      var fileInput = document.getElementById("browseFile");
      if (fileInput) {
          fileInput.addEventListener("change", showFileName);
  
          function showFileName(event) {
              var fileInput = event.srcElement;
              var fileName = fileInput.files[0].name;
              document.getElementById("placeholderInput").placeholder = fileName;
          }
      }
      var fileInp = document.getElementById("browseFil");
      if (fileInp) {
          fileInp.addEventListener("change", showFileName);
  
          function showFileName(event) {
              var fileInp = event.srcElement;
              var fileName = fileInp.files[0].name;
              document.getElementById("placeholderIn").placeholder = fileName;
          }
      }
  
      if ($(".niceSelect1").length) {
          $(".niceSelect1").niceSelect();
      }
</script>
{{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
<script type="text/javascript">
$(function () {
    var $form = $("form#addFeesPayment");
    var publisherKey = '{!! @$method['Stripe']->gateway_publisher_key !!}';
    var ccFalse = false;
    $('form#addFeesPayment').on('submit', function (e) {
        console.log('form');
        var gateway = $('input[name="payment_mode"]:checked').val();
        
        if (gateway == "Stripe") {
            if (!ccFalse) {
                e.preventDefault();
                Stripe.setPublishableKey(publisherKey);
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }
        }  
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
           // $form.find('input[type=text]').empty();

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});

if ($(".primary_select").length) {
    $(".primary_select").niceSelect();
}
</script>
  