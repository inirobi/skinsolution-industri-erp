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
    <h3>Formula List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Formula List</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i>Add New Formula </a>
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
                <th>Formula Number</th>
                <th>Revision Number</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($formula as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->formula_num}} </td>
                <td> {{$data->revision->revision_num}}</td>
                <td> {{$data->created_at}}</td>
                <td class="text-center">
                  <a href="{{route('formula.show',$data->id)}}" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
                  <a onclick="editConfirm({{$data}})" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{route('formula.destroy',$data->id)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('formula.destroy',$data->id)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Formula</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('formula.store') }}" role="form" method="post">
          {{csrf_field()}}
          
          <div class="form-group">
            <label class="control-label">Formula Number</label>
            <input name='formula_num' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Po Customer Number</label>
            <select class="form-control" name="trial_revision_data_id">
                @foreach($revision as $d)
                    <option value="{{$d->id}}" >{{$d->revision_num}}</option>
                @endforeach
            </select>
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
 
<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditLabel">Edit Trial Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" id='editFormula' method="post">
          @method('PUT')
          @csrf
          
          <div class="form-group">
            <label class="control-label">Formula Number</label>
            <input name='formula_num' id='formula_num' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Po Customer Number</label>
            <select class="form-control" name="trial_revision_data_id" id="trial_revision_data_id">
                @foreach($revision as $d)
                    <option value="{{$d->id}}" >{{$d->revision_num}}</option>
                @endforeach
            </select>
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

function editConfirm(data)
{
  console.log(data);
    $('#formula_num').attr('value',data.formula_num);
    $('#trial_revision_data_id').val(data.trial_revision_data_id);
    
    $('#editFormula').attr('action',"{{ url('formula') }}/"+data.id)
    $('#modalEdit').modal();
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