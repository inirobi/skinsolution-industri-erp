@extends('layouts.master')
@section('site-title')
  Packaging Material
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Packaging Receipt List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Packaging Receipt</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add New Packaging Receipt </a>
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
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Date</th>
                <th>Receipt Code</th>
                <th>Packaging Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packaging as $data)
              <tr>
                <td> {{$no++}} </td>
                <td> {{$data->tanggal_recep}}</td>
                <td> {{$data->receipt_code}}</td>
                <td> {{$data->packaging_type}} </td>
                <td class="text-center">
                  <a class="btn btn-info" href="{{route('packaging_receipt.show',$data->id)}}" title="Detail" class="btn btn-small text-primary"><i class="fa fa-eye"></i></a>
                  <a href="#" onclick="editConfirm( '{{$data->id}}', '{{$data->tanggal_recep}}', '{{$data->packaging_type}}', '{{$data->receipt_code}}')" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{ route('packaging_receipt.destroy', $data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('packaging_receipt.destroy', $data->id) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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

<!-- modal Add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Add New Packaging Receipt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" role="form" action="{{route('packaging_receipt.store')}}">
        {{csrf_field()}}
          <div class="form-group">
            <label for="nama" class="col-form-label">Date:</label>
            <fieldset>
              <div class="control-group">
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{ old('date', $lain->date ?? '') }}" name="date">
                          <span class="fa fa-calendar-o form-control-feedback left @error('date') is-invalid @enderror" aria-hidden="true"></span>
                      </div>
                  </div>
              </div> 
            </fieldset>
          </div>
          <div class="form-group">
              <label class="col-form-label  label-align">Packaging Type <code>*</code></label>
              <div class="col-md-12 ">
                <div id="packaging_type" class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-customer">
                      <input type="radio" value="CS" id="packaging_type" name="packaging_type"
                          checked="checked" class="join-btn">
                      &nbsp; Customer
                  </label>
                  <label class="btn btn-secondary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-supplier">
                      <input type="radio" value="SS" id="packaging_type" name="packaging_type"
                          class="join-btn">
                      &nbsp; Supplier
                  </label>
                </div>
              </div>
          </div>
          <div id="option-cs">
            <div class="form-group">
              <label class="col-form-label">Choose Customer</label>
              <select class="form-control" name="customer">
                <option value="">-- Please choose customer --</option>
                @foreach($customers as $customer)
                  <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div id="option-ss">
            <div class="form-group">
              <label class="col-form-label">Choose Supplier</label>
              <select class="form-control" name="supplier">
                <option value="">-- Please choose supplier --</option>
                @foreach($suppliers as $supplier)
                  <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <br>
            <label for="kategori" class="col-form-label">Receipt Code:</label>
            <input type="text" class="form-control" name="receipt_code" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal Update -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Add New Sample Income</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" role="form" id='editReceipt'>
          @method('PUT')
          {{csrf_field()}}
          <div class="form-group">
            <label for="nama" class="col-form-label">Date:</label>
            <fieldset>
              <div class="control-group">
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="dt" placeholder="Date" aria-describedby="date" value="{{ old('date', $lain->date ?? '') }}" name="date" disabled>
                          <span class="fa fa-calendar-o form-control-feedback left @error('date') is-invalid @enderror" aria-hidden="true"></span>
                      </div>
                  </div>
              </div> 
            </fieldset>
          </div>
          <div class="form-group">
              <label class="col-form-label  label-align">Packaging Type <code>*</code></label>
              <div class="col-md-12 ">
                <div id="packaging_type2" class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-customer2">
                      <input type="radio" value="CS" id="packaging_type2" name="packaging_type2"
                          checked="checked" class="join-btn">
                      &nbsp; Customer
                  </label>
                  <label class="btn btn-secondary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-supplier2">
                      <input type="radio" value="SS" id="packaging_type2" name="packaging_type2"
                          class="join-btn">
                      &nbsp; Supplier
                  </label>
                </div>
              </div>
          </div>
          <div id="option-cs2">
            <div class="form-group">
              <label class="col-form-label">Choose Customer</label>
              <select class="form-control" name="customer">
                <option>-- Please choose customer --</option>
                @foreach($customers as $customer)
                  <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div id="option-ss2">
            <div class="form-group">
              <label class="col-form-label">Choose Supplier</label>
              <select class="form-control" name="supplier">
                <option>-- Please choose supplier --</option>
                @foreach($suppliers as $supplier)
                  <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <br>
            <label for="kategori" class="col-form-label">Receipt Code:</label>
            <input type="text" class="form-control" name="receipt_code" id="receipt_code" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
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
<script>
$('select[name=customer]').attr('required','required');
$('#option-cs').show();
$('#option-ss').hide();
$('#option-cs2').show();
$('#option-ss2').hide();
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

function editConfirm(id,date,packaging_type2,receipt_code)
{
  if(packaging_type2=='CS'){
    $('#btn-supplier2').attr('class', 'btn btn-secondary');
    $('#btn-customer2').attr('class', 'btn btn-primary');
    $('select[name=supplier]').attr('required','required');
    $('select[name=customer]').removeAttr('required');
    $('#option-ss2').show();
    $('#option-cs2').hide();
  }
  if(packaging_type2=='SS'){
    $('#btn-supplier2').attr('class', 'btn btn-primary');
    $('#btn-customer2').attr('class', 'btn btn-secondary');
    $('select[name=customer]').attr('required','required');
    $('select[name=supplier]').removeAttr('required');
    $('#option-cs2').show();
    $('#option-ss2').hide();
  }
    $('#dt').attr('value',date);
    $('#receipt_code').attr('value',receipt_code);
    $('#packaging_type2').val(packaging_type2);
    $('#editReceipt').attr('action',"{{ url('packaging_receipt') }}/"+id)
    $('#modalUpdate').modal();
}



    $('input[type=radio][name=packaging_type]').change(function () {
        var source = this.value;
        if (source == "SS") {
            $('#btn-customer').attr('class', 'btn btn-secondary');
            $('#btn-supplier').attr('class', 'btn btn-primary');
            $('select[name=supplier]').attr('required','required');
            $('select[name=customer]').removeAttr('required');
            $('#option-ss').show();
            $('#option-cs').hide();
          }
          if (source == "CS") {
            $('#btn-customer').attr('class', 'btn btn-primary');
            $('#btn-supplier').attr('class', 'btn btn-secondary');
            $('select[name=customer]').attr('required','required');
            $('select[name=supplier]').removeAttr('required');
            $('#option-cs').show();
            $('#option-ss').hide();
        }
    });
    $('input[type=radio][name=packaging_type2]').change(function () {
        var source = this.value;
        if (source == "SS") {
            $('#btn-customer2').attr('class', 'btn btn-secondary');
            $('#btn-supplier2').attr('class', 'btn btn-primary');
            $('#option-ss2').show();
            $('#option-cs2').hide();
        }
        if (source == "CS") {
            $('#btn-customer2').attr('class', 'btn btn-primary');
            $('#btn-supplier2').attr('class', 'btn btn-secondary');
            $('#option-cs2').show();
            $('#option-ss2').hide();
        }
    });
</script>
</script>
    <!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection