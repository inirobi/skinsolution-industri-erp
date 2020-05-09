@extends('layouts.master')
@section('site-title')
  Packaging Material
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
    <h3>Packaging Receipt View Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('packaging_receipt.index')}}">Packaging Receipt</a></li>
            <li><a>Packaging Receipt View</a></li>
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
        <h2>Packaging Receipt View</h2>
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
            <label class="col-form-label col-md-3 col-sm-3  label-align">Receipt Code : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value="{{$packaging->receipt_code}}" name="customer_code" disabled />
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Type : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value="{{$packaging->packaging_type}}" name="customer_code" disabled />
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
        @if($packaging->packaging_type == "CS")  
            <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Packaging </a>
        @endif
        @if($packaging->packaging_type == "SS")  
            <a href="{{route('packaging_receipt.showSS',$packaging->id)}}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Packaging </a>
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
                    <th>Packaging</th>
                    <th>Result</th>
                    <th>Create Date</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1; $total=0; @endphp
                  @foreach($packaging_view as $data)
                    <tr>
                        <td>{{$no++}}</td>
                        <td> {{$data->packaging->packaging_name}} </td>
                        <td> {{$data->quantity}}</td>
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
        <!-- /page content -->
<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Packaging Receipt View Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <form action="{{route('packaging_receipt.storeCS')}}" role="form" method="post">
            {{csrf_field()}}
                <input type="hidden" name="packaging_receipt_id" value='{{$packaging->id}}'>
                <div class="form-group">
                    <label class="control-label col-md-2">Packaging</label>
                    <select class="form-control" name="packaging_id">
                        @foreach($pck as $d)
                            <option value="{{$d->id}}" >{{$d->packaging_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Quantity</label>
                    <input type="text" class="form-control" placeholder="Quantity" required name="quantity">
                </div>
                <div class="modal-footer">
                    <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
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