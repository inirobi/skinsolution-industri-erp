@extends('layouts.master')
@section('site-title')
  Sample Income
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Sample Income List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Samples Sample</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Sample Income </a>
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
                <th>Sample Income Number</th>
                <th>Sample Material</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Price Per Kg</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchase as $data)
              <tr>
                <td> {{$no++}} </td>
                <td> {{$data->purchase_num}} </td>
                <td> {{$data->sample_material->material_name}} </td>
                <td> {{$data->date}}</td>
                <td> {{$data->quantity}}</td>
                <td> {{number_format($data->price)}}</td>
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

<!-- modal detail -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Add New Sample Income</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" role="form" action="{{route('income_samples.store')}}">
        {{csrf_field()}}
          <div class="form-group">
            <label for="kode" class="col-form-label">Income Number:</label>
            <input type="text" class="form-control" name='purchase_num'>
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Sample Material:</label>
            <select class="form-control" name="sample_material_id">
                @foreach($sampleMaterial as $a)
                    <option value="{{$a->id}}" >{{$a->material_name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Date:</label>
            <fieldset>
              <div class="control-group">
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{ old('date', $lain->date ?? '') }}" name="date">
                          <span class="fa fa-calendar-o form-control-feedback left @error('date') is-invalid @enderror" aria-hidden="true"></span>
                      </div>
                  </div>
              </div> 
            </fieldset>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Quantity:</label>
            <input type="number" class="form-control" name='quantity'>
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Price Per Kg:</label>
            <input type="number" class="form-control" name="price">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush


@push('scripts')
</script>
    <!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection