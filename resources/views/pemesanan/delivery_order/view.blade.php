@extends('layouts.master')
@section('site-title')
    Delivery Order View
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Delivery Order View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
                <li><a href="{{route('delivery_order.index')}}">Delivery Order</a></li>
                <li><a>Delivery Order View</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Delivery Order View</h2>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
          <form novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control has-feedback-left" aria-describedby="inputSuccess2Status" value="{{$inv->date}}" disabled>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer<code>*</code></label>
              <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control" value="{{$inv->customer->customer_name}}" disabled>
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Product </a>
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
          <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
                @if(!empty($product))
                @php $no=1; @endphp
                @foreach($delivery_order_view as $data)
                <tr>
                    <td> {{$no++}} </td>
                    <td> {{$data->product->product_name}} </td>
                    <td> {{$data->quantity}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    </div>
  </div>
</div>


<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('delivery_order.view.store')}}" role="form" method="post">
          {{csrf_field()}}
          <input type="hidden" name="delivery_order_id" value="{{$inv->id}}" >
          <div class="form-group">
            <label for="kode" class="col-form-label">Product</label>
            <select class="form-control" name="product_id">
                @foreach($product as $d)
                    <option value="{{$d->id}}" >{{$d->product_name}}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Quantity</label>
            <input type="number" class="form-control" placeholder="Quantity" required name="quantity">
          </div>

          <button type='submit' class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript">
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
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection