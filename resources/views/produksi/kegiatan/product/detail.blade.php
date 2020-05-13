@extends('layouts.master')
@section('site-title')
  Product Activity
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
    <h3>Product Activity Detail Add</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('activity_product.index')}}">Product Activity</a></li>
            <li><a href="{{route('activity_product.show',$productactivity->id)}}">Product Activity View</a></li>
            <li><a>Product Activity Detail  Add</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<form id="addPackaging Receipt View" action="{{route('product_activity.view.store')}}" novalidate method="POST" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Product Activity Detail Add</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <input id="product_activity_id" type="hidden" name="product_activity_id" value="{{$productactivity->id}}">
          <div class="col-sm-12">
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Total Quantity PO : </label>
              <div class="col-md-6 col-sm-6">
                <input id="totqtypo" class="form-control text-capitalize" value="{{$totalQtyPo}}" type="text" disabled>
              </div>
            </div>
            
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Result Target : </label>
              <div class="col-md-6 col-sm-6">
                <input id="result" class="form-control text-capitalize" placeholder="Result Target" type="text"  name="result_target">
              </div>
            </div>
            
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Result Real : </label>
              <div class="col-md-6 col-sm-6">
                <input id="result_real" class="form-control text-capitalize" placeholder="Result Real" type="text"  name="result_real">
              </div>
            </div>
            
            <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Product : </label>
              <div class="col-md-6 col-sm-6">
                <select id="product_id" class="form-control" name="product_id">
                    <option disabled selected value> -- Select PO Number -- </option>
                    @foreach($product as $d)
                        <option value="{{$d->id}}" >{{$d->product_name}}</option>
                    @endforeach
                </select>
              </div>
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
      <!-- <button type="submit" id="product_activity_view_add_button_submit" class="btn btn-success"><i class="fa fa-check"></i>Add Product Activity</button> -->
      <button id="product_activity_view_add_button_submit" class="btn btn-success"><i class="fa fa-check"></i>Add Product Activity</button>
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
            <table class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Material Name</th>
                    <th>Quantity</th>
                    <th>Requirement</th>
                    <th>Weighing</th>
                  </tr>
                </thead>
                <tbody id="formula_detail"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
        <!-- /page content -->


@push('scripts')
<script>
 $('#product_id').on('change', function(e){
    var result = $("#result").val();
    var product_id = e.target.value;
    var idx=0;
        $.get('{{ url('') }}/product_activity/view/add/ajax-state/' + product_id, function(data) {
          $('#formula_detail').empty();
          $.each(data, function(index, subcatObj){
            var requirment = (subcatObj.quantity/100) * result;
            $('#formula_detail')
                .append('<tr><td><input value="'
                +subcatObj.material_name+'" id="material_name'+idx+'" class="form-control  text-capitalize" placeholder="Material Name" type="text" readonly></td><td><input value="'
                +subcatObj.quantity+'" id="quantity'+idx+'" class="form-control text-capitalize" placeholder="Quantity" name="quantity[]" type="text" readonly></td><td>'
                +'<input class="form-control text-capitalize" type="text" value="'+requirment+'" readonly></td><td>'
                +'<input id="weighing'+idx+'" class="form-control text-capitalize" placeholder="Weighing" type="text" name="weighing[]" ></td>'
                +'<input id="material_id'+idx+'" type="hidden" name="material_id[]" value="'+subcatObj.id+'"></td><td>');
                idx++;
        });


        });
    }); 
</script>

    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection