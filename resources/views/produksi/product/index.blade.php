@extends('layouts.master')
@section('site-title')
  Products
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
    <h3>Product List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Products</li>
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
          <a href="{{route('produksi.create')}}" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Product </a>
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
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Customer</th>
                <th>Formula</th>
                <th>Revision</th>
                <th>HPP</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($product as $data)
                @php
                  $xx = App\TrialRevisionData::where('id', $data->trial_revision_data_id)->first(); 
                  @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->product_code}}</td>
                <td> {{$data->product_name}}</td>
                <td> {{$data->customer_name}}</td>
                <td><a target="_blank" href="{{route('produksi.print.formula',$data->formula_id)}}">{{$data->formula_num}}</a></td>
                <td><a href="#">{{$data->revision_num}}</a></td>
                <td class="text-center"><a target="_blank" href="{{route('formula.hpp',$data->formula_id)}}"><i class="fa fa-pencil"></i> List</a></td>
                <td class="text-center">
                  <a href="{{route('produksi.edit',$data->xx)}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{route('produksi.show',$data->xx)}}" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                  <a href="{{route('produksi.destroy',$data->xx)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('produksi.destroy',$data->xx)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
                  <a href="{{route('produksi.print',$data->xx)}}" target="_blank" class="btn btn-primary" title="Print"><i class="fa fa-print"></i></a>
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

<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>



@push('scripts')
<script>

function destroy(action){
    swal({
        title: 'Apakah anda yakin?',
        text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
          document.getElementById('destroy-form').setAttribute('action', action);
          document.getElementById('destroy-form').submit();
        }else {
        swal("Data kamu aman!");
      }
    });
  }
</script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection