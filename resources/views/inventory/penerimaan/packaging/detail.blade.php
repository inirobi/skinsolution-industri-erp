@extends('layouts.master')

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
    <h3>Packaging Receipt View Add</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('packaging_receipt.index')}}">Packaging Receipt</a></li>
            <li><a href="{{route('packaging_receipt.show',$id)}}">Packaging Receipt View</a></li>
            <li><a>Packaging Receipt View Add</a></li>
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
        <h2>Packaging Receipt View Add</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form id="addPackaging Receipt View" action='#' novalidate method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="field item form-group">
            <input type="hidden" id="packaging_receipt_id" name="packaging_receipt_id" value="{{$id}}">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number : </label>
            <div class="col-md-6 col-sm-6">
                <select id="po_packaging_id" class="form-control" name="po_packaging_id">
                    <option disabled selected value> -- Select PO Number -- </option>
                    @foreach($po as $d)
                        <option value="{{$d->id}}" >{{$d->po_num}}</option>
                    @endforeach
                </select>
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
      <button type="submit" id="SubmitPackagingReceiptDetail" class="btn btn-primary"><i class="fa fa-check"></i>Add Packaging Receipt View</button>
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
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Packaging Code</th>
                    <th>Packaging Name</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody id="packaging_detail"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <!-- /page content -->


@push('scripts')
    <script>
        $('#po_packaging_id').on('change', function(e){
                var po_packaging_id = e.target.value;
                var idx=0;
                $.get('{{ url('') }}/packaging_receipt/view/add/ajax-state?po_packaging_id=' + po_packaging_id, function(data) {
                    $('#packaging_detail').empty();
                    $.each(data, function(index, subcatObj){
                        $('#packaging_detail')
                            .append('<tr><td><input value="'
                            +subcatObj.packaging_code+'" class="form-control text-capitalize" type="text" disabled></td><td><input value="'
                            +subcatObj.packaging_name+'" class="form-control  text-capitalize" type="text" disabled></td><td><input value="'
                            +subcatObj.quantity+'" id="quantity'+idx+'" class="form-control text-capitalize" placeholder="Quantity" type="number" name="quantity[]"></td><td>'
                            +'<input id="packaging_id'+idx+'" type="hidden" name="packaging_id[]" value="'+subcatObj.id+'"></td><td>');

                            idx++;
                    }); 


                });
            });


        $('#SubmitPackagingReceiptDetail').click( function(){
            var idx=0;
            var packaging_receipt_id = $("#packaging_receipt_id").val();
            var po_packaging_id = $("#po_packaging_id").val();

            $.get('{{ url('') }}/packaging_receipt/view/add/ajax-state?po_packaging_id=' + po_packaging_id, function(dataDetail) {                
                $.each(dataDetail, function(index, subcatObj){                                    
                    var packaging_id = $("#packaging_id"+idx).val();
                    var quantity = $("#quantity"+idx).val();
                    
                    $.ajax({
                        url: '{{ url('') }}/packaging_receipt/view/storess',
                        type: 'POST',
                        data: {
                            packaging_receipt_id: packaging_receipt_id,
                            packaging_id: packaging_id,
                            quantity: quantity,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (res) {
                            window.location = "{{URL::to('packaging_receipt')}}";
                        }
                    });            

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