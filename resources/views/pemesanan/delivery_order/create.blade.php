@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Delivery Order List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{ route('delivery_order.index') }}">Delivery Orders</a></li>
            @if(isset($inv))
              <li><a> Update Delivery Order</a></li>
            @else
              <li><a>Add Delivery Order</a></li>
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
        @if(isset($inv))
          <form action="{{ route('delivery_order.update', $inv->id) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('delivery_order.store') }}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($inv))
                {{ __('Update Delivery Order') }}
            @else
                {{ __('Form Delivery Order') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Order Number<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('delivery_order_num') is-invalid @enderror" value="{{ old('delivery_order_num', $inv->delivery_order_num ?? '') }}" name="delivery_order_num" required="required" />
            </div>
            @error('delivery_order_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="date" class="form-control has-feedback-left @error('date') is-invalid @enderror" id="single_cal1" aria-describedby="inputSuccess2Status" value="{{ old('date', $inv->date ?? '') }}">
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
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="customer_id">
                  @foreach($customer as $d)
                      <option value="{{$d->id}}" >{{$d->customer_name}}</option>
                  @endforeach
              </select>
            </div>
            @error('customer_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="po_product_id">
                  @foreach($po as $d)
                      <option value="{{$d->id}}" >{{$d->po_num}}</option>
                  @endforeach
              </select>
            </div>
            @error('po_product_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($inv))
              <a href="{{ route('delivery_order.index') }}" class="btn btn-danger">Cancel</a>
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
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection