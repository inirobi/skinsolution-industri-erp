@extends('layouts.master')
@section('site-title')
  Purchase Order Product
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Product View Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('po_product_pemesanan.index')}}">Purchase Order Product</a></li>
            <li><a>Purchase Order Product View</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Purchase Order Products</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="#" novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date : </label>
            <div class="col-md-6 col-sm-6">
              <fieldset>
                  <div class="controls">
                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" value="{{$purchase->date}}" aria-describedby="date" name='date' disabled>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                  </div>
              </fieldset>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value="{{$purchase->po_num}}" disabled />
            </div>
          </div>
        </form>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Product </a>
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
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Quantity Product</th>
                    <th>Pack</th>
                    <th>Total</th>
                    <th>Packaging</th>
                    <th>Labelling</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1; $total=0; @endphp
                  @foreach($purchase_view as $data)
                    @php $total = $data->quantity * $data->pack @endphp
                    <tr>
                        <td>{{$no++}}</td>
                        <td> {{$data->product->product_name}} </td>
                        <td> {{$data->quantity}}</td>
                        <td> {{$data->pack}}</td>
                        <td> {{$total}}</td>
                        <td>   @if($data->packaging == '1')<span class="badge bg-green"> YES </span> @else<span class="badge badge-danger"> NO </span> @endif</td>
                        <td> @if($data->labelling == '1') <span class="badge bg-green"> YES </span> @else <span class="badge badge-danger"> NO </span> @endif</td>
                        <td> {{$data->created_at}}</td>
                        <td>
                          <a href="{{route('po_product_pemesanan.viewDestroy',$data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('po_product_pemesanan.viewDestroy',$data->id) }}');" title="Hapus"><i class="fa fa-trash"></i></a>
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
            <form action="{{route('po_product_pemesanan.viewStore')}}" role="form" method="post">
            {{csrf_field()}}
                <input type="hidden" name="po_product_id" value="{{$purchase->id}}" >
                <div class="form-group">
                    <label class="control-label col-md-2">Product <code>*</code></label>
                    <select class="form-control" name="product_id">
                        @foreach($product as $d)
                            <option value="{{$d->id}}" >{{$d->product_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Quantity <code>*</code></label>
                    <input type="text" class="form-control" required name="quantity">
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Pack <code>*</code></label>
                    <input type="text" class="form-control" required name="pack">
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-2">With Packaging <code>*</code> :</label>
                  <div class="col-md-6 col-sm-6 ">
                    <div id="packaging" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default" id="btn-yes">
                            <input type="radio" value="1" id="packaging" name="packaging"
                                checked="checked" class="join-btn">
                            &nbsp; Yes
                        </label>
                        <label class="btn btn-secondary" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default" id="btn-no">
                            <input type="radio" value="0" id="packaging" name="packaging"
                                class="join-btn">
                            &nbsp; No
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="item form-group">
                  <label class="col-form-label col-md-2">With Labelling <code>*</code> :</label>
                  <div class="col-md-6 col-sm-6 ">
                    <div id="labelling" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default" id="btn-yes-labelling">
                            <input type="radio" value="1" id="labelling" name="labelling"
                                checked="checked" class="join-btn">
                            &nbsp; Yes
                        </label>
                        <label class="btn btn-secondary" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default" id="btn-no-labelling">
                            <input type="radio" value="0" id="labelling" name="labelling"
                                class="join-btn">
                            &nbsp; No
                        </label>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                    <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>

@push('scripts')

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
$('input[type=radio][name=packaging]').change(function () {
    var source = this.value;

    if (source == "0") {
        $('#btn-yes').attr('class', 'btn btn-secondary');
        $('#btn-no').attr('class', 'btn btn-primary');
    }
    if (source == "1") {
        $('#btn-yes').attr('class', 'btn btn-primary');
        $('#btn-no').attr('class', 'btn btn-secondary');
    }
});

$('input[type=radio][name=labelling]').change(function () {
    var source = this.value;

    if (source == "0") {
        $('#btn-yes-labelling').attr('class', 'btn btn-secondary');
        $('#btn-no-labelling').attr('class', 'btn btn-primary');
    }
    if (source == "1") {
        $('#btn-yes-labelling').attr('class', 'btn btn-primary');
        $('#btn-no-labelling').attr('class', 'btn btn-secondary');
    }
});
</script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection