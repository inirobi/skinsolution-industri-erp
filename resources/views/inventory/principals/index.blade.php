@extends('layouts.master')
@section('site-title')
  Principal
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Principals Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Principals</a></li>
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
        <a href="{{ route('principals.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Principal </a>
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
                    <th>Code</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($principals as $data)
                  <tr>
                    <td>{{ $nomor++ }}</td>
                    <td>{{ $data -> principal_code }}</td>
                    <td>{{ $data -> name }}</td>
                    <td>{{ $data -> address }}</td>
                    <td>{{ $data -> country }}</td>
                    <td class="text-center">
                      <a href="{{ route('principals.show', $data) }}" class="btn btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                      <a href="{{ route('principals.edit', $data) }}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('principals.destroy', $data) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('principals.destroy', $data) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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

<script>

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

@push('print')
<div class="page-title">
  <div class="title_left">
    <h3>Principal Lists</h3>
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
							<th>KODE PRINCIPAL</th>
							<th>PRINCIPAL</th>
							<th>SUPPLIER</th>
						</tr>
					</thead>
					<tbody>
            @php $no=1; @endphp
            @foreach($pcl as $data)
              @php $rw=1; @endphp
              @foreach($sup as $data1)
                @if($data1->principal_id == $data->id)
                  <tr id="row1">
                    @if($rw=='1')
                      <td align='center' rowspan="{{$data->count}}">{{$no}}</td>
                      <td rowspan="{{$data->count}}">{{$data->principal_code}}</td>
                      <td rowspan="{{$data->count}}" style="width: 50%;">{{$data->name}}</td>
                    @endif
                    <td style="width: 100%;">{{$data1->supplier_name}}</td>
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
@push('styles')
<style>
#printable { display: none; }

@media print
{
    #non-printable { display: none; }
    #printable { display: block; }
}
</style>
@endpush