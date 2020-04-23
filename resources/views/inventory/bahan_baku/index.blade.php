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
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah </a>
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
          <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Stok Minimal</th>
                <th>Harga</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($materials as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> material_code }}</td>
                <td>{{ $data -> material_name }}</td>
                <td>${{ $data -> stock_minimum }}</td>
                <td>${{ $data -> price }}</td>
                <td class="text-center">
                  <a class="btn btn-info" title="Detail" onclick="detailConfirm('{{ $data -> material_code }}','{{ $data -> material_name }}','{{ $data -> cas_num }}','{{ $data -> inci_name }}','{{ $data -> stock_minimum }}','{{ $data -> category }}','{{ $data -> price }}')" href="#" data-toggle="modal" data-target="#modalDetail" class="btn btn-small text-primary">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="#" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>

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
            <label for="kode" class="col-form-label">Kode:</label>
            <input readonly="" type="text" class="form-control" id="kode">
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Cas Num:</label>
            <input readonly="" type="text" class="form-control" id="cas_num">
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Nama:</label>
            <input readonly="" type="text" class="form-control" id="nama">
          </div>
          <div class="form-group">
            <label for="ukuran" class="col-form-label">Ukuran:</label>
            <textarea readonly="" class="form-control" id="ukuran"></textarea>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Stok Minimal:</label>
            <input readonly="" type="text" class="form-control" id="minimal">
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Kategori:</label>
            <input readonly="" type="text" class="form-control" id="kategori">
          </div>
          <div class="form-group">
            <label for="harga" class="col-form-label">Harga:</label>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Tambah Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" novalidate>
          @csrf
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span
                class="required">*</span></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="namaku"
                placeholder="ex. John f. Kennedy" required="required" />
            </div>
          </div>
          <div class="form-group">
            <label for="kode" class="col-form-label">Kode:</label>
            <input type="text" data-validate-length-range="6" class="form-control" name="kode" required="required">
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Cas Num:</label>
            <input type="text" class="form-control" name="cas_num">
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <div class="form-group">
            <label for="ukuran" class="col-form-label">Ukuran:</label>
            <textarea class="form-control" name="ukuran"></textarea>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Stok Minimal:</label>
            <input type="text" class="form-control" name="minimal">
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Kategori:</label>
            <input type="text" class="form-control" name="kategori">
          </div>
          <div class="form-group">
            <label for="harga" class="col-form-label">Harga:</label>
            <input type="text" class="form-control" name="harga">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal update -->
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
        <!-- <form>
          <div class="form-group">
            <label for="kode" class="col-form-label">Kode:</label>
            <input type="text" class="form-control" id="kode">
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Cas Num:</label>
            <input type="text" class="form-control" id="cas_num">
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" id="nama">
          </div>
          <div class="form-group">
            <label for="ukuran" class="col-form-label">Ukuran:</label>
            <textarea class="form-control" id="ukuran"></textarea>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Stok Minimal:</label>
            <input type="text" class="form-control" id="minimal">
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Kategori:</label>
            <input type="text" class="form-control" id="kategori">
          </div>
          <div class="form-group">
            <label for="harga" class="col-form-label">Harga:</label>
            <input type="text" class="form-control" id="harga">
          </div>
        </form> -->
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

function coba(obj, id) {
  console.log(obj.href);
  console.log(id);
  swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        console.log('value');
        console.log(value);
        var url = 'materials/' + id;
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function(result) {
                // Do something with the result
                alert('kontol babi');
            }
        });
        // if (value) {
        //     window.location.href = url;
        // }
    });
}

$('.delete-confirm').on('Click', function (event) {
    alert('hayu');
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {

        if (value) {
            window.location.href = url;
        }
    });
});
function Yes() {
  swal('Sukses!', 'yeyy', 'success');
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


@include('layouts.validasi_footer')

@endsection