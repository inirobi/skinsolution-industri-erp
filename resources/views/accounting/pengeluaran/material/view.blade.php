@extends('layouts.master')
@section('site-title')
  Purchase Order Material
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Material Detail</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{url('accounting_POmaterial')}}">Purchase Order Material</a></li>
              <li>Purchase Order Material Detail</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Purchase Order Material Detail</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="#" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date : </label>
            <fieldset>
              <div class="control-group">
                <div class="controls">
                  <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{$purchase->po_date}}" disabled>
                    
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value="{{$purchase->suppliers->supplier_name}}" name="customer_code" disabled />
              
            </div>
          </div>
        </form>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Material Detail</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>PO Number</th>
                    <th>Material</th>
                    <th>Quantity</th>
                    <th>Price ({{$purchase->currency}})</th>
                    <th>Total Price ({{$purchase->currency}})</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1; @endphp
                  @foreach($purchase_view as $data)
                    @php 
                      $total_price =  $data->quantity * $data->price;
                    @endphp
                    <tr>
                      <td> {{$data->po_material_id}} </td>
                      <td> {{$data->material->material_name}} - {{$data->material->material_code}} </td>
                      <td> {{$data->quantity}}</td>
                      <td> {{number_format($data->price,2)}}</td>
                      <td> {{number_format($total_price,2)}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <!-- /page content -->

@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection