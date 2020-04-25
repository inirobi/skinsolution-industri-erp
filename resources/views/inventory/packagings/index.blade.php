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
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable"
                                class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                                    @foreach($datas as $data)
                                        @if($data->packaging_type == "CS")
                                            @foreach($data->customers as $customer)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $data -> packaging_code }}</td>
                                                    <td>
                                                        @if($data -> status == "Pending")
                                                        <center>
                                                            <span class='badge badge-warning'> Pending </span>
                                                        </center>
                                                        @else
                                                        <center>
                                                            <span class='badge badge-success'> Oke </span>
                                                        </center>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $data -> packaging_name }}
                                                    </td>
                                                    <td>{{ $data -> category }}</td>
                                                    <td>{{ $data -> stock_minimum }}</td>
                                                    <td>{{ $data -> price }}</td>
                                                    <td>
                                                        {{ $data -> packaging_type }}
                                                        ( {{ $customer->customer_name}} )
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('packagings.edit', $data) }}" class="btn btn-warning"
                                                            title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('packagings.destroy', $data) }}" class="btn btn-danger"
                                                            onclick="event.preventDefault();destroy('{{ route('packagings.destroy', $data) }}')"
                                                            title="Hapus"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach($data->suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $data -> packaging_code }}</td>
                                                    <td>
                                                        @if($data -> status == "Pending")
                                                        <center>
                                                            <span class='badge badge-warning'> Pending </span>
                                                        </center>
                                                        @else
                                                        <center>
                                                            <span class='badge badge-success'> Oke </span>
                                                        </center>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $data -> packaging_name }}
                                                    </td>
                                                    <td>{{ $data -> category }}</td>
                                                    <td>{{ $data -> stock_minimum }}</td>
                                                    <td>{{ $data -> price }}</td>
                                                    <td>
                                                        {{ $data -> packaging_type }}
                                                        ( {{ $supplier->supplier_name}} )
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('packagings.edit', $data) }}" class="btn btn-warning"
                                                            title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('packagings.destroy', $data) }}" class="btn btn-danger"
                                                            onclick="event.preventDefault();destroy('{{ route('packagings.destroy', $data) }}')"
                                                            title="Hapus"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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

@endsection
