@extends('layouts.master')
@section('site-title')
	Material
@endsection

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Material Contradiction List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('materials.index')}}">Materials</a></li>
          <li>Material Contradiction</li>
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
        <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Contradiction </a>
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
              
              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Material Code</th>
                    <th>Material Name</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1
                  @endphp
                  @foreach($datas as $data)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data ->material_code }}</td>
                    <td>{{ $data ->material_name }}</td>
                    <td>{{ $data ->category }}</td>
                    <td class="text-center">
                      <a href="{{route('material.kontradiksi.delete',$data->id_x)}}" onclick="event.preventDefault();destroy('{{route('material.kontradiksi.delete',$data->id_x)}}')" class="btn btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Contradiction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('material.kontradiksi.store')}}">
          {{csrf_field()}}
          <input type="hidden" class="form-control" value="{{$id}}" name="material_id">
          <div class="form-group">
            <label for="kode" class="col-form-label">Material:</label>
              <select class="form-control" name="material_kontradiksi_id">
                  @foreach($material as $a)
                      <option value="{{$a->id}}" >{{$a->material_name}}</option>
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