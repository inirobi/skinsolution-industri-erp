@extends('layouts.master')
@section('site-title')
    Stock Packaging
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Stock Packaging Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Stock Packagings</li>
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
          <h2>Stock Packagings</h2>
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
                <th>Packaging Code</th>
                <th>Packaging Name</th>
                <th>Packaging Type</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stocks as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data -> packaging_code }}</td>
                <td>{{ $data -> packaging_name }}</td>
                <td>{{ $data -> packaging_type }}</td>
                <td>
                  @if($data->quantity <= $data->stock_minimum)<span class="badge badge-danger">{{$data->quantity}}</span>@endif
                  @if($data->quantity > $data->stock_minimum)<span class="badge bg-green">{{$data->quantity}}</span>@endif
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

@endsection
@push('print')
<div class="page-title">
  <div class="title_left">
    <h3>Packaging Stock</h3>
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
							<th>KODE PACKAGING</th>
							<th>CATEGORY</th>
							<th>NAMA PACKAGING</th>
							<th>QUANTITY</th>
						</tr>
					</thead>
					<tbody>
            @php $nomor=1; @endphp
            @foreach($stocks as $data)
            <tr id="row1">
              <td align='center'>{{$nomor++}}</td>
              <td>{{$data->packaging_code}}</td>
              <td>{{$data->category}}</td>
              <td>{{$data->packaging_name}}</td>		
              <td>{{$data->quantity}}</td>
            </tr>
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