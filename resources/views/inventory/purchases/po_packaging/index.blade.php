@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Packaging List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>PO Packagings</a></li>
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
          <a href="{{route('po_packaging.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Packagnig Order </a>
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
                <th>PO Number</th>
                <th>Date</th>
                <th>Supplier Name</th>
                <th>PPN</th>
                <th>Total</th>
                <th>Total Pay</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchase as $data)
                @php
                  $poPackagingdetail =  App\PoPackagingDetail::where('po_packaging_id', $data->id)->get(); 
                  $total = 0;
                  $PPN = 0;
                  foreach ($poPackagingdetail as $dataDetail) {
                      $total = $total + ($dataDetail->quantity * $dataDetail->price);
                  }

                  $PPN = 0.10 * $total;
                  $totalWithPPN = $total + $PPN;
                @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->po_num}} </td>
                <td> {{$data->po_date}}</td>
                <td> {{$data->supplier->supplier_name}}</td>
                <td> 
                    @if($data->ppn==0) 0 @endif
                    @if($data->ppn==1) 10% @endif
                </td>
                <td> {{number_format($total,2)}}</td>
                <td> 
                    @if($data->ppn==0) {{number_format($total,2)}} @endif
                    @if($data->ppn==1) {{number_format($totalWithPPN,2)}} @endif
                </td>
                <td class="text-center">
                  <a class="btn btn-info" href="{{ route('po_packaging.show', $data->id) }}" title="Detail" class="btn btn-small text-primary">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('po_packaging.edit', $data->id) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{ route('po_packaging.destroy', $data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('po_packaging.destroy', $data->id) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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