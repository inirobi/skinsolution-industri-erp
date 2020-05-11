@extends('layouts.master')
@section('site-title')
  Invoice
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Invoice List View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('invoice.index')}}">Invoice List</a></li>
          <li>Invoice List View</li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Input Invoice</h2>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
          <form novalidate method="POST" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jenis Invoice<code>*</code> : </label>
            <div class="col-md-6 col-sm-6">
                DP: &nbsp;
                <input type="radio" class="flat" name="jenis_invoice" value="dp" checked required /> 
                &nbsp;&nbsp;Non Dp: &nbsp
                <input type="radio" class="flat" name="jenis_invoice"value="nodp" />
                &nbsp;&nbsp;Other: &nbsp
                <input type="radio" class="flat" name="jenis_invoice" value="other" />
            </div>
          </div>
          <div class="field item form-group" id="jenis">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jenis DP<code>*</code> : </label>
            <div class="col-md-6 col-sm-6">
                Persen: &nbsp;
                <input type="radio" class="flat" name="jenis_dp" value="persen" id="x"required /> 
                &nbsp;&nbsp;Rupiah: &nbsp
                <input type="radio" class="flat" name="jenis_dp" value="rupiah" id="y"/>
            </div>
          </div>
          <div class="field item form-group" id="persen">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jumlah Persen<code>*</code> : </label>
            <div class="col-md-2 col-sm-2">
              <input class="form-control" id='dp' name="dpPersen" required="required" /> 
            </div>%
          </div>
          <div class="field item form-group" id="rupiah">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jumlah Rupiah<code>*</code> : </label>
            <div class="col-md-2 col-sm-2">
              <input class="form-control" id='dp' name="dpRupiah" required="required" /> 
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Shipped via<code>*</code> : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" name="shipped" required="required" />
            </div>
          </div>
          <div class="col-md12">
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="delivery_orders_num" required="required" />
                  </div>
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</script>
        <!-- /page content -->
@endsection

@push('styles')
   <!-- iCheck -->
   <link href="{{ asset('assets/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>
  $("#rupiah").hide();
  $("#persen").hide();
  $("#x").attr('disabled',false);
  $("#y").attr('disabled',false);
  var radio = $('input[type=radio][name=jenis_invoice]').val();
  console.log(radio);
  $('input[type=radio][name=jenis_invoice]').change(function() {
  var source = this.value;
    console.log("hai");
      if(source=="dp"){
          $("#persen").hide();
          $("#rupiah").hide();
          $("#jenis").show();                
      }
      else if(source=="nondp"){
          $("#persen").hide();
          $("#rupiah").hide();
          $("#jenis").show();                
      }
      else if(source=="other"){
          $("#persen").hide();
          $("#rupiah").hide();
          $("#jenis").show();
          $("#x").attr('disabled',true);
          $("#y").attr('disabled',true);

      }
      $('input[type=radio][name=jenis_dp]').change(function() {
          var x = this.value;
          if(x=="persen"){
              $("#persen").show();
              $("#rupiah").hide();
              $("#jenis").show();                    
          }
          else if(x=="rupiah"){
              $("#persen").hide();
              $("#rupiah").show();
              $("#jenis").show();                    
          }
          
      });    
      
  });
</script>
@endpush