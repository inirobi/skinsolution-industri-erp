@extends('layouts.master')
@section('site-title')
  Customers
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Customers List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Customers</li>
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
        <a href="{{ route('customers.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Customer </a>
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
                    <th>Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($customers as $data)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data -> customer_code }}</td>
                    <td>{{ $data -> customer_name }}</td>
                    <td>{{ $data -> customer_mobile }}</td>
                    <td>{{ $data -> customer_email }}</td>
                    <td>{{ $data -> customer_address }}</td>
                    <td class="text-center">
                      <a href="{{ route('customers.edit', $data) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('customers.destroy', $data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('customers.destroy', $data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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