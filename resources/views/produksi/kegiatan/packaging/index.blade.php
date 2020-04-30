@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Packaging Activity List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-secondary" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
        <a href="{{route('activity_packaging.create')}}" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Packaging Activity </a>
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
          <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Activity Code</th>
                <th>Date</th>
                <th>Production Code</th>
                <th>Product Name</th>
                <th>Production Result</th>
                <th>Packaging Result</th>
                <th>Used Quantity</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packagingactivity as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->activity_code}} </td>
                <td> {{$data->date}}</td>
                <td> {{$data->product_activity->activity_code}}</td>
                <td> {{$data->product->product_name}}</td>
                <td> {{$data->production_result}}</td>
                <td> {{$data->packaging_result}}</td>
                <td> {{$data->used_quantity}}</td>
                <td>
                  @if($data->status=="Pending")<span class="badge badge-warning">Pending</span>@endif
                  @if($data->status=="Release")<span class="badge bg-green">Release</span>@endif
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