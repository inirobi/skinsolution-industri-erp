@extends('layouts.master')
@section('site-title')
  History Delivery Order
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Detail History View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('history.index')}}">History Delivery Order Lists</a></li>
            <li><a href="{{route('history.show',$id)}}">History Delivery Order View</a></li>
            <li><a>Detail History View</a></li>
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
          <h2>Detail History View</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
          <form novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Product Code<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" value="{{$pro->product_code}}" disabled>
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
          </div>
          <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Product Name<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" value="{{$pro->product_name}}" disabled>
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
        <h2>Delivery Order</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
          <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Delivery Order Number</th>
                <th>Quantity</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($inv as $data)
                <tr>
                    <td>{{$no}}</td>
                    <td> {{$data->delivery_order_num}} </td>
                    <td> {{$data->quantity}}</td>
                    <td> {{$data->date}}</td>
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
@endsection