@extends('layouts.master')
@section('site-title')
  Sample Packaging
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Sample Packaging Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Sample Packagings</a></li>
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
          <a href="{{ route('samples_packaging.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Sample Packaging</a>
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
                <th>Packaging Code</th>
                <th>Cas Num</th>
                <th>Packaging Name</th>
                <th>Inci Name</th>
                <th>Supplier Id</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($samples as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> packaging_code }}</td>
                <td>{{ $data -> cas_num }}</td>
                <td>{{ $data -> packaging_name }}</td>
                <td>{{ $data -> inci_name }}</td>
                <td>{{ $data -> supplier_id }}</td>
                <td>{{ $data -> category }}</td>
                <td>{{ $data -> price }}</td>
                <td class="text-center">
                  <a href="{{ route('samples_packaging.edit', $data) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>

                  <a href="{{ route('samples_packaging.destroy', $data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('samples_packaging.destroy', $data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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