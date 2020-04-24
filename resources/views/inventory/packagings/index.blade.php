@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Data Suppliers</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-secondary" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <a href="{{ route('suppliers.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah </a>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
            </div>
          </li>
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
                    <th>Id</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
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

$(document).ready(function(){
  $.get('{{ url('packagings') }}',function(result, state){
    console.log(result);
  })
  // $('#datatable-buttons').DataTable({
  //   processing: true,
  //   serverSide: true,
  //   ajax: '{{ url('packagings') }}',
  //   columns: [
  //     { data: 'id', name: 'id' },
  //     { data: 'category', name: 'category' },
  //   ]
  // });
});

</script>


@endsection