@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Product Stock List</h3>
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
          <h2>Stocks</h2>
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
                <th>Product</th>
                <th>Production Quantity</th>
                <th>Packaging Quantity</th>
                <th>labelling Quantity</th>
                <th>Date End Production</th>
                <th>Date End Packaging</th>
                <th>Date End labelling</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stocks as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->product->product_name}}</td>
                <td> {{$data->production_quantity}}</td>
                <td> {{$data->packaging_quantity}}</td>
                <td> {{$data->labelling_quantity}}</td>
                <td> {{$data->date_end_production}}</td>
                <td> {{$data->date_end_packaging}}</td>
                <td> {{$data->date_end_labelling}}</td>
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