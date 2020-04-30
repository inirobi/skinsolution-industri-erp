@extends('layouts.master')

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
    <h3>
      @if(isset($sts))
          {{ __('Pengeluaran Hasil Labelling Lists') }}
      @else
          {{ __('Pengeluaran Labelling Lists') }}
      @endif
    </h3>
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
          @if(isset($sts))
            <a href="{{route('pengeluaran_labelling2.create2')}}" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Pengeluaran Hasil Labelling </a>
          @else
            <a href="{{route('pengeluaran_labelling.create')}}" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Pengeluaran Labelling </a>
          @endif
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
                <th>Code</th>
                <th>Date</th>
                <th>
                  @if(isset($sts))
                      {{ __('Product') }}
                  @else
                      {{ __('Packaging') }}
                  @endif
                </th>
                <th>Quantity</th>
                <th>Keterangan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($matout as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data->code}}</td>
                <td>{{$data->date}}</td>
                @if(isset($sts))
                  <td>{{$data->product_name}}</td>
                @else
                  <td>{{$data->packaging_name}}</td>
                @endif
                <td>{{$data->quantity}}</td>
                <td>{{$data->keterangan}}</td>
                <td class="text-center">
                  @if(isset($sts))
                    <a href="{{route('pengeluaran_labelling2.edit2', $data->xx)}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  @else
                    <a href="{{route('pengeluaran_labelling.edit', $data->xx)}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  @endif
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