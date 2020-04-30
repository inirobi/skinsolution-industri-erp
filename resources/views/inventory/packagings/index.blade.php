@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3>Packaging Lists</h3>
    </div>
    <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Packagings</a></li>
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
                <a href="{{ route('packagings.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Packaging
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

                            <table id="tabeldata" class="table table-striped table-bordered dt-responsive nowrap"
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
                                <tbody>
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
    $('#kategori').change(function () {
        switch (this.value) {
            case 'CS':
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("packagings/customers/ajax")}}',
                    success: function (response) {
                        $('#tabeldata').DataTable().ajax.url(
                        '{{url("packagings/customers/ajax")}}');
                        $('#tabeldata').DataTable().button().add(0, {
                            action: function (e, dt, button, config) {
                                dt.ajax.reload();
                            },
                            text: 'Reload table'
                        });
                        $('#tabeldata').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                break;
            case 'SS':
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("packagings/suppliers/ajax")}}',
                    success: function (response) {
                        $('#tabeldata').DataTable().ajax.url(
                        '{{url("packagings/suppliers/ajax")}}');
                        $('#tabeldata').DataTable().button().add(0, {
                            action: function (e, dt, button, config) {
                                dt.ajax.reload();
                            },
                            text: 'Reload table'
                        });
                        $('#tabeldata').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                break;

            default:
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("packagings/all/ajax")}}',
                    success: function (response) {
                        $('#tabeldata').DataTable().ajax.url('{{url("packagings/all/ajax")}}');
                        $('#tabeldata').DataTable().button().add(0, {
                            action: function (e, dt, button, config) {
                                dt.ajax.reload();
                            },
                            text: 'Reload table'
                        });
                        $('#tabeldata').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                break;
        }
    });
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{url("packagings/all/ajax")}}',
            success: function (response) {
                $('#tabeldata').DataTable({
                    ajax: {
                        url: '{{url("packagings/all/ajax")}}',
                        dataSrc: ''
                    },
                    "dataType": "json",
                    "columns": [{
                            "data": "rowNumber"
                        },
                        {
                            "data": "packaging_code"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": "packaging_name"
                        },
                        {
                            "data": "category"
                        },
                        {
                            "data": "stock_minimum"
                        },
                        {
                            "data": "price"
                        },
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                var name = (data.packaging_type == 'CS') ? data
                                    .packaging_type + ' - ' + data.customer_name :
                                    data.packaging_type + ' - ' + data
                                    .supplier_name;
                                return '<td>' + name + '</td>';
                            }
                        },
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                var buttons =
                                    '<a href="{{ url("packagings/") }}/' + data
                                    .idData +
                                    '" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>' +
                                    '<a href="{{ url("packagings/") }}/' + data
                                    .idData +
                                    '/edit" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>' +
                                    '<a href="#" class="btn btn-danger" onclick="event.preventDefault();destroy(\'{{ url("packagings/") }}/' +
                                    data.idData +
                                    '\')" title="Hapus"><i class="fa fa-trash"></i></a>';
                                return buttons;
                            }
                        },
                    ]
                });
            },
            error: function (error) {
                alert(error);
            }
        });

    });
</script>
@endpush

@endsection
