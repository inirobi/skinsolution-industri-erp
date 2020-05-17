@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Retur Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Returs</a></li>
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
        <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Retur </a>
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
<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add Retur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('retur.store')}}" role="form" method="post">
          {{csrf_field()}}
          
          <div class="control-group">
            <label class="control-label col-md-3">Date</label>
            <div class="controls">
              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name='date' required>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3">Po Product Number</label>
            <select class="form-control" name="po_customer_ids" id="po_customer_ids">
              <option disabled selected value> -- Select PO Number -- </option>
                @foreach($add as $d)
                    <option value="{{$d->id}}" >{{$d->po_num}}</option>
                @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3">Product</label>
            <select class="form-control" name="products" id="products"></select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3">Quantity Product</label>
            <input type="number" class="form-control" required name="quantity">
          </div>

          <div class="form-group">
            <label class="control-label col-md-3">Quantity Packaging</label>
            <input type="number" class="form-control" required name="quantity_pack">
          </div>

          <div class="form-group">
            <label class="control-label col-md-3">Reason</label>
            <textarea name='reason' class='form-control'></textarea>
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


@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>
    $('#po_customer_ids').on('change', function(e){
        var po_id = e.target.value;
        $.get('{{ url('') }}/retur/add/ajax-state/' + po_id, function(data) {
            $('#products').empty();
            $.each(data, function(index, subcatObj){
                $('#products').append('<option value="'+subcatObj.xx+'">'+subcatObj.product_name+'</option>')
            });


        });
    });
</script>  
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection