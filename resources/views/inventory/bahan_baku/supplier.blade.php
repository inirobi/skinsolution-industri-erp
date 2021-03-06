@extends('layouts.master')
@section('site-title')
	Material
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Material Supplier List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('materials.index')}}">Materials</a></li>
          <li>Material Suppliers</li>
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
        <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Supplier </a>
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
                    <th>Supplier Code</th>
                    <th>Supplier Name</th>
                    <th>Supplier Mobile</th>
                    <th>Email</th>
                    <th>Pic</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1
                  @endphp
                  @foreach($sup as $data)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data -> supplier_code }}</td>
                    <td>{{ $data -> supplier_name }}</td>
                    <td>{{ $data -> supplier_mobile }}</td>
                    <td>{{ $data -> supplier_email }}</td>
                    <td>{{$data->contact_person}}</td>
                    <td class="text-center">
                      <a href="{{ url('material/supplier', $data->id_x) }}" onclick="event.preventDefault();destroy('{{ url('material/supplier', $data->id_x) }}')" class="btn btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>
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

<!-- modal detail -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('material/supplier')}}">
          {{csrf_field()}}
          <input type="hidden" class="form-control" value="{{$id}}" name="material_id">
          <div class="form-group">
            <label for="kode" class="col-form-label">Supplier:</label>
              <select class="form-control" name="supplier_id">
                  @foreach($supplier as $a)
                      <option value="{{$a->id}}" >{{$a->supplier_name}}</option>
                  @endforeach
              </select>
          </div>
          <button type='submit' class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>

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


@endsection