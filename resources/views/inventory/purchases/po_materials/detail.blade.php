@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Material View</h3>
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
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Purchase Order Material</h2>
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
                <input type="text" class="form-control has-feedback-left" id="single_cal1" aria-describedby="inputSuccess2Status" value="{{$purchases[0]->po_date}}" disabled>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier<code>*</code></label>
              <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control" value="{{$purchases[0]->supplier_name}}" disabled>
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
              </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Num<code>*</code></label>
              <div class="col-md-6 col-sm-6">
                <input type="text" class="form-control" value="{{$purchases[0]->po_num}}" disabled>
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
                <th>Price ({{$purchases[0]->currency}})</th>
                <th>Total Price ({{$purchases[0]->currency}})</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchases as $data)
              @php 
                  $total_price =  $data->quantity * $data->price; 
                  $no=1;
              @endphp
              <tr>
                <td>{{$no++}}</td>
                <td> {{$data->material_name}} - {{$data->material_code}} </td>
                <td> {{$data->quantity}}</td>
                <td> {{number_format($data->price,2)}}</td>
                <td> {{number_format($total_price,2)}}</td>
                <td class="text-center">
                  <a href="" class="btn btn-danger" onclick="" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('po_material.store')}}" role="form" method="post">
          {{csrf_field()}}
          <input type="hidden" class="form-control" value="{{$id}}" name="po_material_id">
          <div class="form-group">
            <label for="kode" class="col-form-label">Material</label>
              <select class="form-control" name="supplier_id">
                  @foreach($materials as $a)
                      <option value="{{$a->id}}" >{{$a->material_name}}</option>
                  @endforeach
              </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Quantity</label>
            <input type="text" class="form-control" placeholder="Quantity" required name="quantity">
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Price</label>
            <input id="tch1" type="text" class="form-control" placeholder="Price" required name="price">
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
        <!-- /page content -->
@endsection