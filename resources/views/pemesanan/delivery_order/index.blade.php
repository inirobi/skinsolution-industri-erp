@extends('layouts.master')
@section('site-title')
  Delivery Order
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Delivery Order Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Delivery Order Lists</a></li>
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
      @if(Auth::user()->role == 0)
        <a href="{{ route('delivery_order.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Delivery Order</a>
      @endif  
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
                    <th>Delivery Order Number</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>PO Number</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1 @endphp
                  @foreach($inv as $data)
                  <tr>
                    <td>{{$no++}}</td>
                    <td> {{$data->delivery_order_num}} </td>
                    <td> {{$data->date}}</td>
                    <td> {{$data->customer->customer_name}}</td>
                    <td> {{$data->po_product->po_num}} </td>
                    <td class="text-center">
                    @if(Auth::user()->role == 0)
                      <a href="{{route('delivery_order.print',$data->id)}}" target="_blank" class="btn btn-primary" title="Print"><i class="fa fa-print"></i></a>
                      <a href="{{route('delivery_order.edit',$data->id)}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="{{route('delivery_order.destroy',$data->id)}}" onclick="event.preventDefault();destroy('{{route('delivery_order.destroy',$data->id)}}')" class="btn btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>
                    @endif
                      <a href="{{route('delivery_order.show',$data->id)}}" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
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