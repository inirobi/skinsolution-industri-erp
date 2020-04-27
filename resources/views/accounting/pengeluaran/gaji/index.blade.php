@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Salary Lists</h3>
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
          <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i> Add New Salary </a>
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
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Gaji</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($gaji as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data->bulan}}</td>
                <td>{{$data->tahun}}</td>
                <td>Rp. {{number_format($data->gaji,2)}}</td>
                <td class="text-center">
                  <a href="#" class="btn btn-warning" onclick="editConfirm({{$data->id}},{{$data->bulan}},{{$data->tahun}},{{$data->gaji}})" title="Edit"><i class="fa fa-edit"></i></a>

                  <a href="{{ route('pengeluaran_gaji.destroy',$data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('pengeluaran_gaji.destroy',$data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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
        <h5 class="modal-title" id="modalUpdateLabel">Detail Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id='editGaji' role="form" method="post">
        @method('PUT')
          {{csrf_field()}}
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
            <select class="form-control" id='tahun' name="tahun">
            @php 
            $time = Carbon\Carbon::now();
            $year=$time->format("Y");
            @endphp
            @for($a=2015;$a<=$year;$a++)
                <option value="{{$a}}" >{{$a}}</option>
            @endfor
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Jumlah Gaji</label>
            <input name='gaji' id='gaji' placeholder=" xxx.xxx" type='text' class='form-control' required>
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
        <h5 class="modal-title" id="modalAddLabel">Add New Salary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('pengeluaran_gaji.store') }}" role="form" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-2">Bulan</label>
            <select class="form-control" name="bulan">
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
            <select class="form-control" name="tahun">
            @php 
            $time = Carbon\Carbon::now();
            $year=$time->format("Y");
            @endphp
            @for($a=2015;$a<=$year;$a++)
                <option value="{{$a}}" >{{$a}}</option>
            @endfor
            </select>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Jumlah Gaji</label>
            <input name='gaji' value='' placeholder=" xxx.xxx" type='text' class='form-control' required>
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


<script>

function editConfirm(id,bulan, tahun, gaji)
{
    console.log("{{ url('pengeluaran_gaji') }}/"+id);
    $('#gaji').attr('value',gaji);
    $('#bulan').val(bulan);
    $('#tahun').val(tahun);
    $('#editGaji').attr('action',"{{ url('pengeluaran_gaji') }}/"+id)
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


@endsection