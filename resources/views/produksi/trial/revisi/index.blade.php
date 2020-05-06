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
    <h3>Trial Revision Data List</h3>
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
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i>Add New Trial Revision Data </a>
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
                <th>Revision Number</th>
                <th>Trial Number</th>
                <th>Created From</th>
                <th>Created To</th>
                <th>Keterangan</th>
                <th>Feedback</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($trial as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td> {{$data->revision_num}} </td>
                <td> {{$data->trial->trial_num}}</td>
                <td> {{$data->created_from}} </td>
                <td> {{$data->created_to}}</td>
                <td> {{$data->keterangan}} </td>
                <td> {{$data->feedback}}</td>
                <td class="text-center">
                  <a onclick="editConfirm({{$data}})" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{route('trial_revisi.destroy',$data->id)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('trial_revisi.destroy',$data->id)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Trial Revision</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('trial_revisi.store') }}" role="form" method="post">
          {{csrf_field()}}
          
          <div class="form-group">
            <label class="control-label">Revision Number</label>
            <input name='revision_num' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Trial Number</label>
            <select class="form-control" name="trial_data_id" id="trial_data_id">
              @foreach($trialdata as $d)
                <option value="{{$d->id}}" >{{$d->trial_num}}</option>
              @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                  <label class="control-label col-md-2">Created From</label>
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name="created_from">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                  </div>
              </div>
            </fieldset>
          </div>
          
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                  <label class="control-label col-md-2">Created To</label>
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="Date" aria-describedby="date" name="created_to">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                  </div>
              </div>
            </fieldset>
          </div>

          <div class="form-group">
            <label class="control-label">Procedure</label>
            <textarea name='prosedur' class='form-control' required></textarea>
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
        <h5 class="modal-title" id="modalEditLabel">Edit Trial Revision</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='updateRevisi' role="form" method="post">
          @method('PUT')
          @csrf
          
          <div class="form-group">
            <label class="control-label">Revision Number</label>
            <input name='revision_num' id='revision_num' type='text' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label">Trial Number</label>
            <select class="form-control" name="trial_data_id" id="trial_data_id2">
              @foreach($trialdata as $d)
                <option value="{{$d->id}}" >{{$d->trial_num}}</option>
              @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                  <label class="control-label col-md-2">Created From</label>
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name="created_from">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                  </div>
              </div>
            </fieldset>
          </div>
          
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                  <label class="control-label col-md-2">Created To</label>
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Date" aria-describedby="date" name="created_to">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                  </div>
              </div>
            </fieldset>
          </div>

          <div class="form-group">
            <label class="control-label">Procedure</label>
            <textarea name='prosedur' id='prosedur' class='form-control' required></textarea>
          </div>

          <div class="form-group">
            <label class="control-label">Keterangan</label>
            <textarea name='keterangan' id='keterangan' class='form-control' required></textarea>
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
<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>



@push('scripts')
<script>

function editConfirm(data)
{
  console.log(data);
    $('#keterangan').html(data.keterangan);
    $('#prosedur').html(data.prosedur);
    $('#single_cal2').attr('value',data.created_from);
    $('#single_cal4').attr('value',data.created_to);
    $('#single_cal4').val(data.created_to);
    let me = $('#single_cal4').val();
    console.log(me);
    $('#trial_data_id2').attr('value',data.trial_num);
    $('#revision_num').attr('value',data.revision_num);

    $('#updateRevisi').attr('action',"{{ url('trial_revisi') }}/"+data.id)
    $('#modalEdit').modal();
}

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