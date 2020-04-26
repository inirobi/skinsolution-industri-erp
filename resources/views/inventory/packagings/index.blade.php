@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3>Data Packagings</h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <a href="{{ route('packagings.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah
                </a>

                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <div class="form-group">
                            <label class="col-form-label col-md-4 col-sm-4 ">Kategori</label>
                            <div class="col-md-8 col-sm-8 ">
                                <select class="select2_single form-control" id="kategori">
                                    <option value="ALL" selected>All</option>
                                    <option value="CS">Customer</option>
                                    <option value="SS">Supplier</option>
                                </select>
                            </div>
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
                            
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Status</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Stok Minimum</th>
                                        <th>Harga</th>
                                        <th>Tipe</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <a href="{{ route('packagings.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah
                </a>

                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <div class="form-group">
                            <label class="col-form-label col-md-4 col-sm-4 ">Kategori</label>
                            <div class="col-md-8 col-sm-8 ">
                                <select class="select2_single form-control" id="kategori">
                                    <option value="ALL" selected>All</option>
                                    <option value="CS">Customer</option>
                                    <option value="SS">Supplier</option>
                                </select>
                            </div>
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
                            
                            <table id="" class="table table-striped table-bordered nowrap mydatatable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>1</th>
                                        <td>01231</td>
                                        <td>Lukiame</td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <td>018731</td>
                                        <td>Mikqnerui</td>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <td>091832</td>
                                        <td>Uimowa</td>
                                    </tr>
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
    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                document.getElementById('destroy-form').setAttribute('action', action);
                document.getElementById('destroy-form').submit();
            } else {
                swal("Data kamu aman!");
            }
        });
    }

</script>

@push('beforeScripts')
<script>
    $('.input-sm').change(function () {
        alert('hi');
    });
    $.get('{{url("packagings/all/ajax")}}', function (data) {
        $('#tabel-data').empty();
        $.each(data, function (index, subcatObj) {
            var nama = (subcatObj.packaging_type == "CS") ? subcatObj.customer_name : subcatObj
                .supplier_name;
            var urlDetail = '{{ url("packagings/") }}' + '/' + subcatObj.idData;
            var urlEdit = '{{ url("packagings/") }}' + '/' + subcatObj.idData + '/edit';
            $('#tabel-data').append(
                `<tr role="row">
                    <td role="row">` + subcatObj.rowNumber + `</td>
                    <td role="row">` + subcatObj.packaging_code + `</td>
                    <td role="row">` + subcatObj.status + `</td>
                    <td role="row">` + subcatObj.packaging_name + `</td>
                    <td role="row">` + subcatObj.category + `</td>
                    <td role="row">` + subcatObj.stock_minimum + `</td>
                    <td role="row">` + subcatObj.price + `</td>
                    <td role="row">` + subcatObj.packaging_type + ` ( ` + nama + ` )</td>
                    <td role="row" class="text-center">
                      <a href="` + urlDetail + `" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                      <a href="` + urlEdit + `" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="` + urlDetail + `" class="btn btn-danger" onclick="event.preventDefault();destroy('` +
                urlDetail + `')" title="Hapus"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                `
            )
        });
    });
    $('#kategori').change(function () {
        switch (this.value) {
            case 'CS':
                $.get('{{url("packagings/customers/ajax")}}', function (data) {
                    $('#tabel-data').empty();
                    var cek = true;
                    $.each(data, function (index, subcatObj) {
                        var nama = (subcatObj.packaging_type == "CS") ? subcatObj
                            .customer_name : subcatObj.supplier_name;
                        var urlDetail = '{{ url("packagings/") }}' + '/' + subcatObj.idData;
                        var urlEdit = '{{ url("packagings/") }}' + '/' + subcatObj.idData +
                            '/edit';
                        $('#tabel-data').append(
                            `<tr role="row">
                    <td role="row">` + subcatObj.rowNumber + `</td>
                    <td role="row">` + subcatObj.packaging_code + `</td>
                    <td role="row">` + subcatObj.status + `</td>
                    <td role="row">` + subcatObj.packaging_name + `</td>
                    <td role="row">` + subcatObj.category + `</td>
                    <td role="row">` + subcatObj.stock_minimum + `</td>
                    <td role="row">` + subcatObj.price + `</td>
                    <td role="row">` + subcatObj.packaging_type + ` ( ` + nama + ` )</td>
                    <td role="row" class="text-center">
                      <a href="` + urlDetail + `" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                      <a href="` + urlEdit + `" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="` + urlDetail + `" class="btn btn-danger" onclick="event.preventDefault();destroy('` +
                            urlDetail + `')" title="Hapus"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                `
                        )
                    });
                });
                break;
            case 'SS':
                $.get('{{url("packagings/suppliers/ajax")}}', function (data) {
                    $('#tabel-data').empty();
                    $.each(data, function (index, subcatObj) {
                        var nama = (subcatObj.packaging_type == "CS") ? subcatObj
                            .customer_name : subcatObj.supplier_name;
                        var urlDetail = '{{ url("packagings/") }}' + '/' + subcatObj.idData;
                        var urlEdit = '{{ url("packagings/") }}' + '/' + subcatObj.idData +
                            '/edit';
                        $('#tabel-data').append(
                            `<tr role="row">
                    <td role="row">` + subcatObj.rowNumber + `</td>
                    <td role="row">` + subcatObj.packaging_code + `</td>
                    <td role="row">` + subcatObj.status + `</td>
                    <td role="row">` + subcatObj.packaging_name + `</td>
                    <td role="row">` + subcatObj.category + `</td>
                    <td role="row">` + subcatObj.stock_minimum + `</td>
                    <td role="row">` + subcatObj.price + `</td>
                    <td role="row">` + subcatObj.packaging_type + ` ( ` + nama + ` )</td>
                    <td role="row" class="text-center">
                      <a href="` + urlDetail + `" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                      <a href="` + urlEdit + `" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="` + urlDetail + `" class="btn btn-danger" onclick="event.preventDefault();destroy('` +
                            urlDetail + `')" title="Hapus"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                `
                        )
                    });
                });
                break;

            default:
                $.get('{{url("packagings/all/ajax")}}', function (data) {
                    $('#tabel-data').empty();
                    $.each(data, function (index, subcatObj) {
                        var nama = (subcatObj.packaging_type == "CS") ? subcatObj
                            .customer_name : subcatObj.supplier_name;
                        var urlDetail = '{{ url("packagings/") }}' + '/' + subcatObj.idData;
                        var urlEdit = '{{ url("packagings/") }}' + '/' + subcatObj.idData +
                            '/edit';
                        $('#tabel-data').append(
                            `<tr role="row" >
                    <td role="row">` + subcatObj.rowNumber + `</td>
                    <td role="row">` + subcatObj.packaging_code + `</td>
                    <td role="row">` + subcatObj.status + `</td>
                    <td role="row">` + subcatObj.packaging_name + `</td>
                    <td role="row">` + subcatObj.category + `</td>
                    <td role="row">` + subcatObj.stock_minimum + `</td>
                    <td role="row">` + subcatObj.price + `</td>
                    <td role="row">` + subcatObj.packaging_type + ` ( ` + nama + ` )</td>
                    <td role="row" class="text-center">
                      <a href="` + urlDetail + `" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                      <a href="` + urlEdit + `" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="` + urlDetail + `" class="btn btn-danger" onclick="event.preventDefault();destroy('` +
                            urlDetail + `')" title="Hapus"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                `
                        )
                    });
                });
                break;
        }
        console.log('dicoba dulu');
        console.log('barangkali oke');
    });

    $('.mydatatable').DataTable();

</script>
@endpush

@endsection