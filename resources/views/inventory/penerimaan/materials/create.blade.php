@extends('layouts.master')
@section('site-title')
  Receipment Material
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Receipment Materials Add</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('purchases_material.index')}}">Receipment Materials</a></li>
          <li>Receipment Materials Add</li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<form action="{{route('purchases_material.store')}}" method="POST" enctype="multipart/form-data" id="form-tambah">
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_content">
        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">Add New Receipment Materials</span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Purchase Number<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" name="purchase_num" id="purchase_num" required="required" />
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6 date">
                <input type="text" class="form-control has-feedback-left " id="single_cal1" aria-describedby="inputSuccess2Status" name='date'>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Delivery Orders Num<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" id='delivery_orders_num' name="delivery_orders_num" required="required" />
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select id="po_material_id" class="form-control" name="po_material_id">
                  <option disabled selected value> -- Select PO Number -- </option>
                  @foreach($poMaterial as $d)
                      <option value="{{$d->id}}" >{{$d->po_num}}</option>
                  @endforeach
              </select>
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
        <button id="y" class="btn btn-primary"><i class="fa fa-check"></i> Add Purchase</button>
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Material Code</th>
                <th>Material Name</th>
                <th>Quantity (gram)</th>
                <th>Expired Date</th>
                <th>Analis Number</th>
                <th>Batch Number</th>
              </tr>
            </thead>
            <tbody id="material_detail"></tbody>
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

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>

$('#po_material_id').on('change', function(e){
  var po_material_id = e.target.value;
  var idx=0;
  $.get('{{ url('') }}/purchase/add/ajax-state/' + po_material_id, function(data) {
    $('#material_detail').empty();
      $.each(data, function(index, subcatObj){
        $('#material_detail')
          .append('<tr><td><input value="'
          +subcatObj.material_code+'" class="form-control text-capitalize" placeholder="Material Code" type="text" disabled></td><td><input value="'
          +subcatObj.material_name+'" class="form-control  text-capitalize" placeholder="Material Name" type="text" disabled></td><td><input value="'
          +subcatObj.quantity * 1000+'" id="quantity'+idx+'" class="form-control text-capitalize" placeholder="Quantity" type="number" name="quantity[]"></td><td>'
          +'<div class="input-group expired_date date" ><input type="text" class="form-control" id="expired_date'+idx+'" name="expired_date[]" /><span class="input-group-addon"><span class="fa fa-calendar"></span></span></td><td>'
          +'<input id="analis_num'+idx+'" class="form-control text-capitalize" placeholder="Analis Number" type="text" name="analis_num[]"></td><td>'
          +'<input id="batch_num'+idx+'" class="form-control  text-capitalize" placeholder="Batch Number" type="text" name="batch_num[]">'
          +'<input id="material_id'+idx+'" type="hidden" name="material_id[]" value="'+subcatObj.id+'"></td><td>');
      idx++;
    });
  });
});

$('#y').click( function(){
  var po_m_id = $("#po_material_id").val();
  var idx=0;
  var purchase_num = $("#purchase_num").val();
  var date = $("#single_cal1").val();
  var delivery_orders_num = $("#delivery_orders_num").val();
  var po_material_id = $("#po_material_id").val();

  var purchase = [purchase_num,date,delivery_orders_num,po_material_id];
  confirm(purchase);
  $.ajax({
    url: '{{ url('') }}/purchase/store/ajax-state',
    type: 'post',
    data: {
        purchase_num: purchase_num,
        date: date,
        delivery_orders_num: delivery_orders_num,
        po_material_id: po_material_id,
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    dataType: 'json',
    success: function(data){
      $.ajax({
        url:'{{url('')}}/purchase/add/ajax-state/' + po_m_id,
        type: 'GET',
        dataType: 'JSON',
        success: function(dataDetail){
          var idx=0;
          $.each(dataDetail, function(index, subcatObj){
            var purchase_id = data;
            var material_id = $("#material_id"+idx).val();
            var quantity = $("#quantity"+idx).val();
            var expired_date = $("#expired_date"+idx).val();
            var batch_num = $("#batch_num"+idx).val();
            var analis_num = $("#analis_num"+idx).val(); 
            $.ajax({
                url: '{{ url('') }}/purchase/view/store/ajax-state',
                type: 'post',
                data: {
                    purchase_id: purchase_id,
                    material_id: material_id,
                    quantity: quantity,
                    expired_date: expired_date,
                    batch_num: batch_num,
                    analis_num: analis_num,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success:function(res){
                    window.location = "{{URL::to('purchases_material')}}";
                    // $('#form-tambah').submit();
                }
            });            
            idx++;
          });
        }
      });
    }
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