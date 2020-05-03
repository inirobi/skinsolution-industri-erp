@extends('layouts.master')

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Invoice Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Invoices</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Invoice </a>
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
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th>PO Number</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($inv as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->invoice_num}} </td>
                <td> {{$data->date}}</td>
                <td> {{$data->customer_name}}</td>
                <td> {{$data->po_num}} </td>
                @if(!empty($not->first()))
                  @php $no=0; @endphp
                @foreach($not as $dd) 
                  @if($data->id==$dd->id_invo)
                    @php $no++; @endphp
                    @endif
                @endforeach 
                @if($no=='1')
                  <td><span class="badge badge-danger">{{$data->status}}</span></td>
                @else 
                  <td>{{$data->status}}</td>
                @endif
                @else 
                  <td>{{$data->status}}</td>
                @endif
                <td class="text-center">
                  <a href="#" class="btn btn-info" title="View"><i class="fa fa-eye"></i></a>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('invoice.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Invoice Number</label>
            <input name="invoice_num" type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <fieldset>
              <div class="control-group">
                <label class="control-label col-md-2">Date</label>
                <div class="controls">
                  <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name='date' required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2">Jenis PO <code>*</code> :</label>
            <div class="col-md-6 col-sm-6 ">
              <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-yes">
                      <input type="radio" value="trial" name="jenis_po"
                          checked="checked" class="join-btn">
                      &nbsp; Trial
                  </label>
                  <label class="btn btn-secondary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-no">
                      <input type="radio" value="produksi" name="jenis_po"
                          class="join-btn">
                      &nbsp; Produksi
                  </label>
                </div>
              </div>
            </div>

          <div class="form-group">
            <label class="control-label col-md-2">Customer</label>
            <select class="form-control" name="customer_id" id="customer_id">
            <option disabled selected value> -- Select Customer -- </option>
                @foreach($customer as $d)
                    <option value="{{$d->id}}" >{{$d->customer_name}}</option>
                @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-2">PO Number</label>
            <select class="form-control" name="po_product_id" id="po_num"></select>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-2">Terms</label>
            <select class="form-control" name="terms">
                <option value="Cash" >Cash</option>
                <option value="7 Days" >7 Days</option>
                <option value="14 Days" >14 Days</option>
                <option value="30 Days" >30 Days</option>
                <option value="Other" >Other</option>
            </select>
          </div>

          
            <br>
          <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
$('input[type=radio][name=jenis_po]').change(function() {
    var jenis_po = this.value; 
    $('#customer_id').on('change', function(e){
        var customer_id = e.target.value;
        $.ajax({
          url: 'invoice/xx/',
          type: "get",
          data: {jenis_po: jenis_po, customer_id: customer_id},
            success: function(data){
                
                $('#po_num').empty();
                $.each(data, function(index, subcatObj){
                $('#po_num').append('<option value="'+subcatObj.xxx+'">'+subcatObj.po_num+'</option>')
    
                  });

                
            }
        });
        
    });
    
});

$('input[type=radio][name=jenis_po]').change(function () {
    var source = this.value;

    if (source == "produksi") {
        $('#btn-yes').attr('class', 'btn btn-secondary');
        $('#btn-no').attr('class', 'btn btn-primary');
    }
    if (source == "trial") {
        $('#btn-yes').attr('class', 'btn btn-primary');
        $('#btn-no').attr('class', 'btn btn-secondary');
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