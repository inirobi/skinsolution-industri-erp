@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
                <li><a href="{{route('po_material.index')}}">PO Materials</a></li>
              @if(isset($purchase))
                <li><a>Update PO Materials</a></li>
              @else
                <li><a>Add PO Materials</a></li>
              @endif
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
      <div class="x_content">
        @if(isset($purchase))
          <form action="{{route('po_material.update',$purchase->id)}}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{route('po_material.store')}}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($purchase))
                {{ __('Update Purchase Order') }}
            @else
                {{ __('Add New Purchase Order') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('material_code') is-invalid @enderror" value="{{ old('po_num', $purchase->po_num ?? '') }}" name="po_num" required="required" />
            </div>
            @error('po_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6 date">
                <input type="text" class="form-control has-feedback-left @error('date') is-invalid @enderror" id="single_cal1" aria-describedby="inputSuccess2Status" name='date' value="{{ old('date', $dateOut ?? '') }}">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supllier<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="supplier_id">
                @foreach($supplier as $d)
                    <option  value="{{$d->id}}" 
                    @if ($d->id == old('supplier_id', $purchase->supplier_id))
                        selected="selected"
                    @endif
                    >{{$d->supplier_name}}</option>
                @endforeach
              </select>
            </div>
            @error('supplier_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Terms<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" @if(isset($purchase)) disabled @endif name="terms">
                  <option
                    @if ('Cash'== old('supplier_id', $purchase->terms))
                        selected="selected"
                    @endif
                   value="Cash" >Cash</option>
                  <option 
                    @if ('7 Days'== old('terms', $purchase->terms))
                        selected="selected"
                    @endif
                   value="7 Days" >7 Days</option>
                  <option 
                    @if ('14 Days'== old('terms', $purchase->terms))
                        selected="selected"
                    @endif
                   value="14 Days" >14 Days</option>
                  <option 
                    @if ('30 Days'== old('terms', $purchase->terms))
                        selected="selected"
                    @endif
                   value="30 Days" >30 Days</option>
              </select>
            </div>
            @error('terms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Currency<code>*</code></label>
            <div class="col-md-12 ">
              <div id="currency" class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-idr">
                    <input type="radio" value="IDR" id="currency" name="currency" class="join-btn" checked="checked">
                    &nbsp; IDR (Rp)
                </label>
                <label class="btn btn-secondary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-usd">
                    <input type="radio" value="USD" id="currency" name="currency" class="join-btn" >
                    &nbsp; USD ($)
                </label>
              </div>
            </div>
          </div>
          <div class="field item form-group" id="kurs">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Kurs<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control " value="{{ old('kurs', $purchase->kurs ?? '') }}" type="text" name="kurs">
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PPN<code>*</code></label>
            <div class="col-md-12 ">
              <div id="ppn" class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-yes">
                    <input type="radio" value="1" id="ppn" name="ppn" class="join-btn" checked="checked">
                    &nbsp; Yes
                </label>
                <label class="btn btn-secondary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-no">
                    <input type="radio" value="0" id="ppn" name="ppn"
                        class="join-btn">
                    &nbsp; No
                </label>
              </div>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Description<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea rows="3" class="form-control" name="description">{{ old('description', $purchase->description ?? '') }}</textarea>
            </div>
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
                <button type='submit' class="btn btn-primary">Submit</button>
                @if(isset($materials))
                  <a href="{{ route('materials.index') }}" class="btn btn-danger">Cancel</a>
                @else
                  <button type="reset" class="btn btn-success">Reset</button>
                @endif
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>
  $("#kurs").hide();
  $('input[type=radio][name=currency]').change(function() {
      var source = this.value;
      
      if(source=="USD"){
          $("#kurs").show();
      }
      if(source=="IDR"){
          $("#kurs").hide();
      }
  });

  $('input[type=radio][name=ppn]').change(function () {
      var source = this.value;
      if (source == "0") {
          $('#btn-yes').attr('class', 'btn btn-secondary');
          $('#btn-no').attr('class', 'btn btn-primary');
      }
      if (source == "1") {
          $('#btn-yes').attr('class', 'btn btn-primary');
          $('#btn-no').attr('class', 'btn btn-secondary');
      }
  });
  $('input[type=radio][name=currency]').change(function () {
      var source = this.value;
      if (source == "USD") {
          $('#btn-idr').attr('class', 'btn btn-secondary');
          $('#btn-usd').attr('class', 'btn btn-primary');
      }
      if (source == "IDR") {
          $('#btn-idr').attr('class', 'btn btn-primary');
          $('#btn-usd').attr('class', 'btn btn-secondary');
      }
  });
</script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection