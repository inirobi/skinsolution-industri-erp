@extends('layouts.master')
@section('site-title')
  Cash Flow
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
    <h3>Cash Flow Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Cash Flows</a></li>
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
        <h2>Cash Flows</h2>
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success pull-right" ><i class="fa fa-plus"></i> Add New Cash Flow </a>
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
                <th>Tanggal</th>
                <th>Money</th>
                <th>Status</th>
                <th>Saldo</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($petty as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td > {{$data->date}} </td>
                <td>Rp. {{number_format($data->money,2)}}</td>
                <td>@if($data->status == '1') <span class="badge bg-green"> Debit </span>@else<span class="badge badge-danger"> Kredit </span>@endif</td>
                <td>Rp. {{number_format($data->saldo,2)}}</td>
                <td  > {{$data->keterangan}} </td>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Cash Flow</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('petty.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                <label class="control-label col-md-2">Tanggal <code>*</code></label>
                <div class="controls">
                  <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name='date' required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Money <code>*</code></label>
            <input name='money' placeholder=" xxx.xxx" type='number' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="col-form-label col-md-2 col-sm-2">Status <code>*</code></label>
              <div id="status" class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-customer">
                    <input type="radio" value="1" id="status" name="status"
                        checked="checked" class="join-btn">
                    &nbsp; Debit
                </label>
                <label class="btn btn-secondary" data-toggle-class="btn-primary"
                    data-toggle-passive-class="btn-default" id="btn-supplier">
                    <input type="radio" value="0" id="status" name="status"
                        class="join-btn">
                    &nbsp; Kredit
                </label>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Keterangan</label>
            <textarea name='keterangan' class='form-control' required></textarea>
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

<script>
$('input[type=radio][name=status]').change(function () {
    var source = this.value;

    if (source == "0") {
        $('#btn-customer').attr('class', 'btn btn-secondary');
        $('#btn-supplier').attr('class', 'btn btn-primary');
    }
    if (source == "1") {
        $('#btn-customer').attr('class', 'btn btn-primary');
        $('#btn-supplier').attr('class', 'btn btn-secondary');
    }
});
</script>

<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection