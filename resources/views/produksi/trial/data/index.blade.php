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
    <h3>Trial Data List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Trial Data List</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i>Add New Trial Data </a>
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
                <th>Trial Number</th>
                <th>PO Customer Number</th>
                <th>Product Name</th>
                <th>Willingness</th>
                <th>Type</th>
                <th>Keterangan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($trial as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->trial_num}} </td>
                <td> {{$data->po_customer->po_num}}</td>
                <td> {{$data->po_customer_detail->product_name}}</td>
                <td> {{$data->willingness}} </td>
                <td> 
                    @if($data->type==0)<span class="badge badge-info">Dekoratif</span>@endif
                    @if($data->type==1)<span class="badge bg-green">Skin Care</span>@endif
                </td>
                <td> {{$data->keterangan}} </td>
                <td class="text-center">
                  <a onclick="editConfirm({{$data}})" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{route('trial.destroy',$data->id)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('trial.destroy',$data->id)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Trial Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('trial.store') }}" role="form" method="post">
          {{csrf_field()}}
          
          <div class="form-group">
            <label class="control-label">Trial Number</label>
            <input name='trial_num' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Po Customer Number</label>
            <select class="form-control" name="po_customer_id" id="po_customer_id">
              @foreach($pocustomer as $d)
                <option value="{{$d->id}}" >{{$d->po_num}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Product</label>
            <select class="form-control" name="po_customer_detail_id" id="po_customer_detail_id"></select>
          </div>

          <div class="form-group">
            <label class="control-label">Willingness</label>
            <input name='willingness' type='text' class='form-control' required>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2">Type <code>*</code> :</label>
            <div class="col-md-6 col-sm-6 ">
              <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-yes">
                      <input type="radio" value="1" name="type"
                          checked="checked" class="join-btn">
                      &nbsp; Skin Care
                  </label>
                  <label class="btn btn-secondary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-no">
                      <input type="radio" value="0" name="type"
                          class="join-btn">
                      &nbsp; Dekoratif
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Keterangan</label>
              <textarea name='keterangan' class='form-control' required></textarea>
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


<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditLabel">Edit Trial Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" id='editTrial' method="post">
          @method('PUT')
          @csrf
          
          <div class="form-group">
            <label class="control-label">Trial Number</label>
            <input name='trial_num' id="trial_num" type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Po Customer Number</label>
            <select class="form-control" name="po_customer_id" id="po_customer_id2">
              @foreach($pocustomer as $d)
                <option value="{{$d->id}}" >{{$d->po_num}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Product</label>
            <select class="form-control" name="po_customer_detail_id" id="po_customer_detail_id2"></select>
          </div>

          <div class="form-group">
            <label class="control-label">Willingness</label>
            <input name='willingness' id="willingness" type='text' class='form-control' required>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2">Type <code>*</code> :</label>
            <div class="col-md-6 col-sm-6 ">
              <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-primary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-yes2">
                      <input type="radio" id='id1' value="1" name="type"
                          checked="checked" class="join-btn">
                      &nbsp; Skin Care
                  </label>
                  <label class="btn btn-secondary" data-toggle-class="btn-primary"
                      data-toggle-passive-class="btn-default" id="btn-no2">
                      <input type="radio" id='id2' value="0" name="type"
                          class="join-btn">
                      &nbsp; Dekoratif
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Keterangan</label>
              <textarea name='keterangan' id="keterangan" class='form-control' required></textarea>
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


@push('scripts')
<script>
$('#po_customer_id').on('change', function(e){
  var po_id = e.target.value;
  $.get('{{ url('') }}/trial/add/ajax-state/' + po_id, function(data) {
      $('#po_customer_detail_id').empty();
      $.each(data, function(index, subcatObj){
      $('#po_customer_detail_id').append('<option value="'+subcatObj.id+'">'+subcatObj.product_name+'</option>')
    });
  });
});
$('#po_customer_id2').on('change', function(e){
  var po_id = e.target.value;
  $.get('{{ url('') }}/trial/add/ajax-state/' + po_id, function(data) {
      $('#po_customer_detail_id2').empty();
      $.each(data, function(index, subcatObj){
      $('#po_customer_detail_id2').append('<option value="'+subcatObj.id+'">'+subcatObj.product_name+'</option>')
    });
  });
});

function editConfirm(data)
{
  console.log(data);
    $('#keterangan').html(data.keterangan);
    $('#willingness').attr('value',data.willingness);
    $('#po_customer_id2').attr('value',data.po_customer_id);
    $('#po_customer_detail_id2').append('<option value="'+data.po_customer_detail.id+'">'+data.po_customer_detail.product_name+'</option>');
    $('#trial_num').attr('value',data.trial_num);

      if (data.type == "0") {
      $('input[type=radio][name=type]').attr('value',0);
          $('#btn-yes2').attr('class', 'btn btn-secondary');
          $('#btn-no2').attr('class', 'btn btn-primary');
      }
      if (data.type == "1") {
        $('input[type=radio][name=type]').attr('value',1);
        $('#btn-yes2').attr('class', 'btn btn-primary');
        $('#btn-no2').attr('class', 'btn btn-secondary');
      }
    $('#editTrial').attr('action',"{{ url('trial') }}/"+data.id)
    $('#modalEdit').modal();
}

$('input[type=radio][name=type]').change(function () {
  $('#id1').attr('value',1);
  $('#id2').attr('value',0);
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
$('input[type=radio][name=type]').change(function () {
    var source = this.value;

    if (source == "0") {
        $('#btn-yes2').attr('class', 'btn btn-secondary');
        $('#btn-no2').attr('class', 'btn btn-primary');
    }
    if (source == "1") {
        $('#btn-yes2').attr('class', 'btn btn-primary');
        $('#btn-no2').attr('class', 'btn btn-secondary');
    }
});

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