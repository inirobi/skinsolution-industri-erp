@extends('layouts.master')
@section('site-title')
  Product Activity
@endsection
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Product Activity View Detail</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('activity_product.index')}}">Product Activity</a></li>
            <li><a href="{{route('activity_product.show',$productactivity->id)}}">Product Activity View</a></li>
            <li><a>Product Activity View Detail</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<form novalidate method="POST" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Product Activity View Detail</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <input id="product_activity_id" type="hidden" name="product_activity_id" value="{{$productactivity->id}}">
          <div class="col-sm-12">
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Product : </label>
              <div class="col-md-6 col-sm-6">
                <input id="totqtypo" class="form-control text-capitalize" value="{{$productCode->product->product_name}}" type="text" disabled>
              </div>
            </div>
            
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Result : </label>
              <div class="col-md-6 col-sm-6">
                <input value="{{$productCode->result_real}}" disabled class="form-control text-capitalize" placeholder="Result Target" type="text"  name="result_target">
              </div>
            </div>
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
                    <th>No</th>
                    <th>Material Name</th>
                    <th>Quantity</th>
                    <th>Weighing</th>
                    <th>Create Date</th>
                  </tr>
                </thead>
                <tbody>
                @php $no = 1; @endphp
                @foreach($activity_view as $data)
                  <tr>
                    <td>{{$no++}}</td>
                    <td> {{$data->material_name}}</td>
                    <td> {{$data->quantity}}</td>
                    <td> {{$data->weighing}}</td>
                    <td> {{$data->created_at}}</td>
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
</form>
        <!-- /page content -->

@endsection