@extends('layouts.master')
@section('site-title')
  Penjualan
@endsection
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
    <h3>Penjualan Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Penjualan</a></li>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Penjualan </a>
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
                <th>Tanggal</th>
                <th>Keteranagan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Harga Penjualan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($penjualan as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data->date}}</td>
                <td>{{$data->keterangan}}</td>
                <td>{{$data->bulan}}</td>
                <td>{{$data->tahun}}</td>
                <td>Rp. {{number_format($data->penjualan,2)}}</td>
                <td class="text-center">
                  <a href="#" class="btn btn-warning" onclick="editConfirm( '{{$data->id}}', '{{$data->date}}', '{{$data->keterangan}}', '{{$data->bulan}}', '{{$data->tahun}}', '{{$data->penjualan}}')" title="Edit"><i class="fa fa-edit"></i></a>

                  <a href="{{ route('penjualan.destroy',$data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('penjualan.destroy',$data) }}');" title="Hapus"><i class="fa fa-trash"></i></a>
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


<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateLabel">Update Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id='editPennjualan' role="form" method="post">
        @method('PUT')
          {{csrf_field()}}
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                  <label class="control-label col-md-2">Tanggal</label>
                  <div class="controls">
                      <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name="date">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                  </div>
              </div>
              </fieldset>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Keterangan</label>
            <textarea name='keterangan' id='keterangan' class='form-control' required></textarea>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Bulan</label>
            <select id='bulan' class="form-control" name="bulan">
                <option value="1" >Januari</option>
                <option value="2" >Februari</option>
                <option value="3" >Maret</option>
                <option value="4" >April</option>
                <option value="5" >Mei</option>
                <option value="6" >Juni</option>
                <option value="7" >Juli</option>
                <option value="8" >Agustus</option>
                <option value="9" >September</option>
                <option value="10" >Oktober</option>
                <option value="11" >November</option>
                <option value="12" >Desember</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Tahun</label>
            <select class="form-control" id='tahun' name="tahun" required>
            @php 
            $time = Carbon\Carbon::now();
            $year=$time->format("Y");
            $x=$year-5;
            @endphp
            @for($a=$x;$a<=$year;$a++)
                <option value="{{$a}}" >{{$a}}</option>
            @endfor
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Harga Penjualan</label>
            <input name='penjualan' id='penjualan' placeholder=" xxx.xxx" type='text' class='form-control' required>
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

<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('penjualan.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <fieldset>
              <div class="control-group">
                <label class="control-label col-md-2">Tanggal</label>
                <div class="controls">
                  <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name='date' required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Keterangan</label>
            <textarea name='keterangan' class='form-control' required></textarea>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Bulan</label>
            <select id='bulan' class="form-control" name="bulan">
                <option value="1" >Januari</option>
                <option value="2" >Februari</option>
                <option value="3" >Maret</option>
                <option value="4" >April</option>
                <option value="5" >Mei</option>
                <option value="6" >Juni</option>
                <option value="7" >Juli</option>
                <option value="8" >Agustus</option>
                <option value="9" >September</option>
                <option value="10" >Oktober</option>
                <option value="11" >November</option>
                <option value="12" >Desember</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Tahun</label>
            <select class="form-control" id='tahun' name="tahun" required>
            @php 
            $time = Carbon\Carbon::now();
            $year=$time->format("Y");
            $x=$year-5;
            @endphp
            @for($a=$x;$a<=$year;$a++)
                <option value="{{$a}}" >{{$a}}</option>
            @endfor
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Harga Penjualan</label>
            <input name='penjualan' id='gaji' placeholder=" xxx.xxx" type='text' class='form-control' required>
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

function editConfirm(id,date,keterangan,bulan, tahun,penjualan)
{
    $('#keterangan').html(keterangan);
    $('#single_cal3').attr('value',date);
    $('#penjualan').attr('value',penjualan);
    $('#bulan').val(bulan);
    $('#tahun').val(tahun);
    $('#editPennjualan').attr('action',"{{ url('penjualan') }}/"+id)
    $('#modalUpdate').modal();
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