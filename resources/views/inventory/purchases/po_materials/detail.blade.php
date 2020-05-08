@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Material View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
                <li><a href="{{route('po_material.index')}}">PO Materials</a></li>
                <li><a>PO Materials View</a></li>
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
          <h2>Purchase Order  View</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
          <form novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control has-feedback-left" aria-describedby="inputSuccess2Status" value="{{$purchase->po_date}}" disabled>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier<code>*</code></label>
              <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control" value="{{$purchase->suppliers->supplier_name}}" disabled>
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
              </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Num<code>*</code></label>
              <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control" value="{{$purchase->po_num}}" disabled>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Material </a>
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
                <th>Material</th>
                <th>Quantity (KG)</th> 
                <th>Price (IDR)</th>
                <th>Total Price (IDR)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchase_view as $data)
              @php 
                  $total_price =  $data->quantity * $data->price; 
                  $no=1;
              @endphp
              <tr>
                <td>{{$no++}}</td>
                <td> {{$data->material->material_name}} - {{$data->material->material_code}} </td>
                <td> {{$data->quantity}}</td>
                @if($purchase->currency=="USD")
                  <td>{{number_format($purchase->kurs * $data->price,2)}}</td>
                @else
                  <td>{{number_format($data->price,2)}}</td>
                @endif

                @if($purchase->currency=="USD")
                  <td> {{number_format($purchase->kurs*$total_price,2)}}</td>
                @else
                <td> {{number_format($total_price,2)}}</td>
                @endif
                
                <td class="text-center">
                <a href="{{ route('po_material.destroyView', $data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('po_material.destroyView', $data->id) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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


<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('po_material.viewStore')}}" role="form" method="post">
          {{csrf_field()}}
          <input type="hidden" name="po_material_id" value="{{$purchase->id}}" >
          <div class="form-group">
            <label for="kode" class="col-form-label">Material</label>
            <select class="form-control" name="material_id">
              @foreach($material as $d)
                <option value="{{$d->id}}" >{{$d->material_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Quantity</label>
            <input type="number" class="form-control" placeholder="Quantity" required name="quantity">
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Price</label>
            <input type="number" class="form-control" placeholder="Quantity" required name="price">
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