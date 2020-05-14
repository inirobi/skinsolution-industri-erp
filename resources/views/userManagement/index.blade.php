@extends('layouts.master')
@section('site-title')
  User Management
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>User Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>User</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New User </a>
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
                <th>User Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($admin as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->name}} </td>
                <td> {{$data->email}}</td>
                <td> 
                    @if($data->role=='0') Admin @endif
                    @if($data->role=='1') Material Warehouse @endif
                    @if($data->role=='2') Accounting @endif
                    @if($data->role=='3') RnD @endif
                    @if($data->role=='4') Production @endif
                    @if($data->role=='5') Packaging @endif
                    @if($data->role=='6') Labelling @endif
                    @if($data->role=='7') Qc @endif
                    @if($data->role=='8') Customer @endif
                </td>
                <td> {{$data->created_at}} </td>
                <td class="text-center">
                  <a href="#" class="btn btn-warning" onclick="editConfirm({{$data}})" title="Edit"><i class="fa fa-edit"></i></a>

                  <a href="{{ route('user_management.destroy',$data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('user_management.destroy',$data) }}');" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalUpdateLabel">Update Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id='editUser' role="form" method="post">
        @method('PUT')
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">User Name</label>
            <input name='name' id='name' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Email</label>
            <input name='email' id='email' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Password</label>
            <input id='password' name='password' type='password' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Role</label>
            <select class="form-control" name="role" id="role">
              <option value="1" >Material Warehouse</option>
              <option value="2" >Accounting</option>
              <option value="3" >RnD</option>
              <option value="4" >Production</option>
              <option value="5" >Packaging</option>
              <option value="6" >Labelling</option>
              <option value="7" >QC</option>
              <option value="8" >Customer</option>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user_management.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">User Name</label>
            <input name='name' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Email</label>
            <input name='email' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Password</label>
            <input name='password' type='password' class='form-control' required>
          
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Role</label>
            <select class="form-control" name="role" >
              <option value="1" >Material Warehouse</option>
              <option value="2" >Accounting</option>
              <option value="3" >RnD</option>
              <option value="4" >Production</option>
              <option value="5" >Packaging</option>
              <option value="6" >Labelling</option>
              <option value="7" >QC</option>
              <option value="8" >Customer</option>
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
    $('#name').attr('value',data.name);
    $('#email').attr('value',data.email);
    $('#role').val(data.role);
    $('#editUser').attr('action',"{{ url('user_management') }}/"+data.id)
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
@endpush

@endsection