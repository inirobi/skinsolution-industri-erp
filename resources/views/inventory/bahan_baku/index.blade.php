@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Data Bahan Baku</h3>
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
          <a href="{{ route('materials.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah </a>
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
                <th>Material Code</th>
                <th>Material Name</th>
                <th>Stock Minimum</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($materials as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> material_code }}</td>
                <td>{{ $data -> material_name }}</td>
                <td>{{ $data -> stock_minimum }}</td>
                <td>${{ $data -> price }}</td>
                <td class="text-center">
                  <a class="btn btn-info" title="Detail" onclick="detailConfirm('{{ $data -> material_code }}','{{ $data -> material_name }}','{{ $data -> cas_num }}','{{ $data -> inci_name }}','{{ $data -> stock_minimum }}','{{ $data -> category }}','{{ $data -> price }}')" href="#" data-toggle="modal" data-target="#modalDetail" class="btn btn-small text-primary">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('materials.edit', $data) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>

                  <a href="{{ route('materials.destroy', $data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('materials.destroy', $data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
                  
                  <!-- <a href="#" class="btn btn-danger" onclick="javascript:coba(this, '{{ $data->id }}')" title="Hapus"><i class="fa fa-trash"></i></a> -->
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


<!-- modal detail -->
<div class="modal fade bd-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="kode" class="col-form-label">Material Code:</label>
            <input readonly="" type="text" class="form-control" id="kode">
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Cas Num:</label>
            <input readonly="" type="text" class="form-control" id="cas_num">
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Material Name:</label>
            <input readonly="" type="text" class="form-control" id="nama">
          </div>
          <div class="form-group">
            <label for="ukuran" class="col-form-label">Inci Name:</label>
            <textarea readonly="" class="form-control" id="ukuran"></textarea>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Stock Minimum:</label>
            <input readonly="" type="text" class="form-control" id="minimal">
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Category:</label>
            <input readonly="" type="text" class="form-control" id="kategori">
          </div>
          <div class="form-group">
            <label for="harga" class="col-form-label">Price:</label>
            <input readonly="" type="text" class="form-control" id="harga">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function detailConfirm(kode, nama, cas_num,ukuran,minimal, kategori, harga)
{

    $('#kode').attr('value',kode);
    $('#nama').attr('value',nama);
    $('#cas_num').attr('value',cas_num);
    // $('#id-reg').attr('value',id_reg);
    $('#ukuran').html(ukuran);
    $('#minimal').attr('value',minimal);
    
    $('#kategori').attr('value',kategori);
    $('#harga').attr('value',harga);

    $('#modalDetail').modal();
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


@endsection