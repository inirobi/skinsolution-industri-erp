@extends('layouts.master')
@section('site-title')
  Purchase Order Trial
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Trial List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Purchase Order Trial</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New PO Trial </a>
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
                <th>Po Number</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchase as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->po_num}} </td>
                <td> {{$data->customer_name}}</td>
                <td> {{$data->date}}</td>
                <td> {{$data->status}}</td>
                <td class="text-center">
                  <a href="{{route('po_customer.show',$data->id) }}" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
                  <a href="#" class="btn btn-warning" onclick="editConfirm( '{{$data->id}}', '{{$data->po_num}}', '{{$data->customer_id}}', '{{$data->date}}', '{{$data->status}}')" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{route('po_customer.destroy',$data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('po_customer.destroy',$data->id) }}');" title="Hapus"><i class="fa fa-trash"></i></a>
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


<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateLabel">Update Sale</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id='editPennjualan' role="form" method="post">
        @method('PUT')
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Po Number</label>
            <input id='po_num' name='po_num' type='text' class='form-control' required>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-2">Customer</label>
            <select class="form-control" name="customer_id" id="customer_id">
                @foreach($customer as $d)
                    <option value="{{$d->id}}" >{{$d->customer_name}}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <fieldset>
              <div class="control-group">
                <label class="control-label col-md-2">Date</label>
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
            <label class="control-label col-md-2">Status</label>
            <textarea id='status' name='status' class='form-control' required></textarea>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New PO Trial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('po_customer.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Po Number</label>
            <input name='po_num' type='text' class='form-control' required>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-2">Customer</label>
            <select class="form-control" name="customer_id">
                @foreach($customer as $d)
                    <option value="{{$d->id}}" >{{$d->customer_name}}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <fieldset>
              <div class="control-group">
                <label class="control-label col-md-2">Date</label>
                <div class="controls">
                  <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name='date' required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Status</label>
            <textarea name='status' class='form-control' required></textarea>
          </div>
          <div class="modal-footer">
            <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </div>
        </form>
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

function editConfirm(id,po_num,customer_id,date, status)
{
    $('#status').html(status);
    $('#po_num').attr('value',po_num);
    $('#single_cal2').attr('value',date);
    $('#customer_id').val(customer_id);
    $('#editPennjualan').attr('action',"{{ url('po_customer') }}/"+id)
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