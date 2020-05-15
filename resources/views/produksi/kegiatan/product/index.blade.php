@extends('layouts.master')
@section('site-title')
  Product Activity
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Product Activity List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Product Activity</a></li>
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
        @if(Auth::user()->role == 0)
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Product Activity </a>
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
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Activity Code</th>
                <th>Date Start</th>
                <th>Date Start</th>
                <th>PO Product Number</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($productactivity as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->activity_code}} </td>
                <td> {{$data->date_start}}</td>
                <td> {{$data->date_end}}</td>
                <td> {{$data->po_num}}</td><td>
                  @if($data->status=="Pending")<span class="badge badge-warning">Pending</span>@endif
                  @if($data->status=="Release")<span class="badge bg-green">Release</span>@endif
                </td>
                <td> {{$data->keterangan}}</td>
                <td class="text-center">
                  <a href="{{route('activity_product.show',$data->id)}}" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
                  @if(Auth::user()->role == 0)
                    <a href="#" class="btn btn-warning" onclick="editConfirm( '{{$data->id}}', '{{$data->activity_code}}', '{{$data->date_start}}', '{{$data->keterangan}}', '{{$data->po_product_id}}')" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{route('activity_product.destroy',$data->id)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('activity_product.destroy',$data->id)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Purchase Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('activity_product.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Activity Code</label>
            <input type="text" class="form-control" required name="activity_code">
          </div>
          <div class="control-group">
            <label class="control-label col-md-2">Date Start</label>
            <div class="controls">
              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name='date_start' required>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">PO Product</label>
            <select class="form-control" name="po_product_id">
                @foreach($po as $d)
                    <option value="{{$d->id}}" >{{$d->po_num}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Keterangan</label>
            <textarea name='keterangan' class='form-control'></textarea>
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

<!-- modal Update -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateLabel">Update Purchase Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='editActive' action='' role="form" method="post">
        @method('PUT')
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Activity Code</label>
            <input type="text" class="form-control" required id='activity_code' name="activity_code">
          </div>
          <div class="control-group">
            <label class="control-label col-md-2">Date Start</label>
            <div class="controls">
              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="single_cal" placeholder="Date" aria-describedby="date" name='date_start' required>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">PO Product</label>
            <select class="form-control" id='po_product_id' name="po_product_id">
                @foreach($po as $d)
                    <option value="{{$d->id}}" >{{$d->po_num}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Keterangan</label>
            <textarea id='keterangan' name='keterangan' class='form-control'></textarea>
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

<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>

function editConfirm(id,activity_code,date,keterangan,po_product_id)
{
    $('#single_cal').attr('value',date);
    $('#activity_code').attr('value',activity_code);
    $('#po_product_id').val(po_product_id);
    $('#keterangan').html(keterangan);
    $('#editActive').attr('action',"{{ url('activity_product') }}/"+id)
    $('#modalUpdate').modal();
}

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