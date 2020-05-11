@extends('layouts.master')
@section('site-title')
  Receipment Material
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3> Receipment Material Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Receipment Materials</li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <a href="{{route('purchases_material.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Receipment Material </a>
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
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Purchase Number</th>
                <th>Order Number</th>
                <th>Date</th>
                <th>PO Number</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchases as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> purchase_num }}</td>
                <td>{{ $data -> delivery_orders_num }}</td>
                <td>{{ $data -> date }}</td>
                <td>{{ $data -> po_num }}</td>
                <td class="text-center">
                  <a href="{{ route('purchases_material.show', $data->id) }}"><button class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button></a>
                </td>
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