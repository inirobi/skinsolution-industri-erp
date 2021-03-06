@extends('layouts.master')
@section('site-title')
  Pengeluaran Sample Packaging
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Pengeluaran Sample Packaging</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Pengeluaran Sample Packaging</li>
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
          <a href="{{route('pengeluaran_sample_pck.create')}}" class="btn btn-success" ><i class="fa fa-plus"></i>Add New Packaging</a>
          <ul class="nav navbar-right panel_toolbox">
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
                <th>Code</th>
                <th>Date</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Keterangan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packout as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data->code}}</td>
                <td>{{$data->date}}</td>
                <td>{{$data->packaging_name}}</td>
                <td>{{$data->quantity}}</td>
                <td>{{$data->keterangan}}</td>
                <td class="text-center">
                  <a href="{{route('pengeluaran_sample_pck.edit',$data->xx)}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a> 
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


@push('scripts')
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection