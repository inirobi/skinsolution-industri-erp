@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Retur Lists</h3>
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
        <a href="#" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Retur </a>
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
                <th>Code Return</th>
                <th>Date</th>
                <th>PO Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Quantity Packaging</th>
                <th>Reason</th>
              </tr>
            </thead>
            <tbody>
              @foreach($retur as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->kode_return}} </td>
                <td> {{$data->tanggal_retur}}</td>
                <td> {{$data->po_num}}</td>
                <td> {{$data->product_name}}</td>
                <td> {{$data->quantity_retur}} </td>
                <td> {{$data->quantity_pack}}</td>
                <td> {{$data->alasan}}</td>
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