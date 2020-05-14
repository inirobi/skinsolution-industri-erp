@extends('layouts.master')
@section('site-title')
	Material
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Materials List</h3>
  </div>
  
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Materials</li>
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
          <a href="{{ route('materials.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Material </a>
          <button class="pull-right btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
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
                <th>Code Material</th>
                <th>Name Material</th>
                <th>Cas Number</th>
                <th>Inci Name</th>
                <th>Stock Minimum</th>
                <th>Cantegory</th>
                <th>Price</th>
                <th>Contradiction</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($materials as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> material_code }}</td>
                <td>{{ $data -> material_name }}</td>
                <td>{{ $data -> cas_num }}</td>
                <td>{{ $data -> inci_name }}</td>
                <td>{{ $data -> stock_minimum }}</td>
                <td>{{ $data -> category }}</td>
                <td>Rp {{number_format($data -> price,2)}}</td>
                <td class="text-center"><a href="{{ route('material.kontradiksi.show', $data) }}"><i class="fa fa-pencil"></i> List</a></td>
                <td class="text-center">
                  <a class="btn btn-primary" href="{{ route('material.print', $data->id) }}" target="_blank" title="Lihat Kartu Stok {{ $data -> material_name }}" class="btn btn-small text-primary">
                    <i class="fa fa-file-text-o"></i>
                  </a>
                  <a href="{{ route('materials.edit', $data) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                  <a href="{{ route('materials.destroy', $data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('materials.destroy', $data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
                  <a class="btn btn-info" href="{{ route('materials.show', $data) }}" title="Detail" class="btn btn-small text-primary">
                    <i class="fa fa-eye"></i>
                  </a>
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


<!-- modal detail -->
<div class="modal fade bd-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="kode" class="col-form-label">Material Code:</label>
            <input readonly="" type="text" class="form-control" id="kode">
          </div>
          <div class="form-group">
            <label for="cas_num" class="col-form-label">Cas Num:</label>
            <input readonly="" type="text" class="form-control" id="cas_num">
          </div>
          <div class="form-group">
            <label for="nama" class="col-form-label">Material Name:</label>
            <input readonly="" type="text" class="form-control" id="nama">
          </div>
          <div class="form-group">
            <label for="ukuran" class="col-form-label">Inci Name:</label>
            <textarea readonly="" class="form-control" id="ukuran"></textarea>
          </div>
          <div class="form-group">
            <label for="minimal" class="col-form-label">Stock Minimum:</label>
            <input readonly="" type="text" class="form-control" id="minimal">
          </div>
          <div class="form-group">
            <label for="kategori" class="col-form-label">Category:</label>
            <input readonly="" type="text" class="form-control" id="kategori">
          </div>
          <div class="form-group">
            <label for="harga" class="col-form-label">Price:</label>
            <input readonly="" type="text" class="form-control" id="harga">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@push('print')
<div class="page-title">
  <div class="title_left">
    <h3>Materials List</h3>
  </div>
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div style='float:right;text-align:right'>
			<img src="{{asset('assets/src/img/logo-skin-care.png')}}" />
			<br><br>
			<h2 style="font-size:14pt">PT. SKINSOLUTION INDUSTRI BEAUTY CARE INDONESIA <br>
				<small>
					Jalan Waruga Jaya No. 47, Ciwaruga <br>
					Parongpong, 40559 <br>
					West Java, Indonesia <br>
					Phone:(022) 820-270-55 <br>
				</small>
			</h2>
		</div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

	<div class="row" style="display: block;">
		<div class="col-md-12  ">
			<div class="x_content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>NO</th>
							<th>KODE MATERIAL</th>
							<th>MATERIAL</th>
							<th>SUPPLIER</th>
						</tr>
					</thead>
					<tbody>
          @php $no=1; @endphp
          @foreach($mat as $data)
            @php $rw=1; @endphp
              @foreach($sup as $data1)
                @if($data1->material_id == $data->id)
                  <tr>
                    @if($rw=='1')
                      <th scope="row" style="justify-content:center" rowspan="{{$data->count}}">{{$no}}</th>
                      <td rowspan="{{$data->count}}" style="justify-content:center">{{$data->material_code}}</td>
                      <td rowspan="{{$data->count}}" style="justify-content:center">{{$data->material_name}}</td>
                    @endif
                      <td>{{$data1->supplier_name}}</td>
                  </tr>
                  @php $rw++; @endphp
                @endif
              @endforeach	
            @php $no++; @endphp
          @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endpush
<script>
function detailConfirm(kode, nama, cas_num,ukuran,minimal, kategori, harga)
{

    $('#kode').attr('value',kode);
    $('#nama').attr('value',nama);
    $('#cas_num').attr('value',cas_num);
    // $('#id-reg').attr('value',id_reg);
    $('#ukuran').html(ukuran);
    $('#minimal').attr('value',minimal);
    
    $('#kategori').attr('value',kategori);
    $('#harga').attr('value',harga);

    $('#modalDetail').modal();
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
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

@endsection