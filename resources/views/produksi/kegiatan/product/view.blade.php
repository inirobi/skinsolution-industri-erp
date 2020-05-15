@extends('layouts.master')
@section('site-title')
  Product Activity
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
    <h3>Product Activity View Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('activity_product.index')}}">Product Activity</a></li>
            <li><a>Product Activity View</a></li>
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
        <h2>Product Activity View</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="#" novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date : </label>
            <div class="col-md-6 col-sm-6">
              <div class="controls">
                <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                  <input value="{{$productactivity->date_start}}" type="text" class="form-control has-feedback-left" id="single_cal3" disabled placeholder="Date" aria-describedby="date" name='date_start'>
                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Activity Code : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value="{{$productactivity->activity_code}}" name="customer_code" disabled />
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
        @if(Auth::user()->role == 0)
          <a href="{{route('activity_product.view.add',$productactivity->id)}}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Product </a>
        @endif
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
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Result</th>
                    @if(Auth::user()->role == 0)
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1; 
                    $cekProduct=0; 
                  
                  @endphp
                  @foreach($activity_view as $data)
                    @if($cekProduct != $data->product_id)
                    @php  $cekProduct = $data->product_id; @endphp
                    <tr>
                        <td>{{$no++}}</td>
                        <td> {{$data->product->product_name}} </td>
                        <td> {{$data->result_real}}</td>
                        @if(Auth::user()->role == 0)
                          <td><a href="{{route('product_activity.viewsub',[$data->product_activity_id,$data->product_id])}}" class='btn btn-warning' ><i class="fa fa-eye"></i></a></td>
                        @endif
                    </tr>
                    @endif
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

@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection