@extends('layouts.master')
@section('site-title')
    Packaging Print
@endsection
@section('content')

<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">KARTU PERSEDIAAN BAHAN KEMAS</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<td>Code Packaging</td>
					<td>Packaging</td>
					<td>Unit</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$packaging->packaging_code}}</td>
					<td>{{$packaging->packaging_name}}</td>
					<td></td>
				</tr>
			</tbody>
		</table>
  </div>
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div style='float:right;text-align:right'>
			<img src="{{asset('assets/src/img/logo-skin-care.png')}}" />
			<br><br>
			<h2>PT. SKINSOLUTION INDUSTRI BEAUTY CARE INDONESIA <br>
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
	<div class="col-md-6 col-sm-6  ">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="text-align:center" colspan="4">MASUK</th>
					</tr>
					<tr >
						<th style="text-align:center">TGL</th>
						<th style="text-align:center">KET</th>														
						<th style="text-align:center">QTY</th>
					</tr>
				</thead>
				<tbody>
					@foreach($recept as $data)
					<tr id="row1">
						<td>{{substr($data->created_at,0,10)}}</td>
						<td>{{$data->receipt_code}}</td>
						<td>{{$data->quantity}}</td> 
					</tr>
					@endforeach
					
					@foreach($retur as $datax)
					<tr id="row1">
						<td>{{substr($datax->tanggal_retur,0,10)}}</td>
						<td>{{$datax->packaging_code}}</td>
						<td>{{$datax->quantity_retur}}</td>
					</tr>
					@endforeach
					<tr>
						<th style="text-align:right">Total</th>
						<th style="text-align:center">:</th>
						<th>{{$masuk}}</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-6 col-sm-6  ">
	<div class="x_content">
		<table class="table table-striped">
			<thead>
				<tr>
					<th style="text-align:center" colspan="3">KELUAR</th>
				</tr>
				<tr>
					<th style="text-align:center">TGL</th>
					<th style="text-align:center">KET</th>
					<th style="text-align:center">QTY</th>
				</tr>
			</thead>
			<tbody>
				@foreach($activity as $datay)
				<tr id="row1">
					<td>{{substr($datay->date,0,10)}}</td>
					<td>{{$datay->activity_code}}</td>
					<td>{{$datay->used_quantity}}</td>
				</tr>
				@endforeach
				@foreach($pack as $dataz)
				<tr id="row1">
					<td>{{substr($dataz->date,0,10)}}</td>
					<td>{{$dataz->code}}</td>
					<td>{{$dataz->quantity}}</td>
				</tr>
				@endforeach
				<tr>
					<th style="text-align:right">Total</th>
					<th style="text-align:center">:</th>
					<th>{{$keluar}}</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12  ">
	<div class="x_content">
		<hr>
		<p style="text-align:right;font-size:14pt;color:#000;padding-right:100px"><strong>Sisa = {{$sisa}}</strong> </p>
		<hr>
	</div>
</div>

<div class='pull-right'>
	<button onclick="javascript:window.print()" class='btn btn-info'><i class="fa fa-print"></i> Print</button>
</div>
<div class="clearfix"></div>
@endsection

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

@push('print')
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">KARTU PERSEDIAAN BAHAN KEMAS</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<td>Code Packaging</td>
					<td>Packaging</td>
					<td>Unit</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$packaging->packaging_code}}</td>
					<td>{{$packaging->packaging_name}}</td>
					<td></td>
				</tr>
			</tbody>
		</table>
  </div>
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div style='float:right;text-align:right'>
			<img src="{{asset('assets/src/img/logo-skin-care.png')}}" />
			<br><br>
			<h2>PT. SKINSOLUTION INDUSTRI BEAUTY CARE INDONESIA <br>
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
	<div class="col-md-6 col-sm-6  ">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="text-align:center" colspan="4">MASUK</th>
					</tr>
					<tr >
						<th style="text-align:center">TGL</th>
						<th style="text-align:center">KET</th>														
						<th style="text-align:center">QTY</th>
					</tr>
				</thead>
				<tbody>
					@foreach($recept as $data)
					<tr id="row1">
						<td>{{substr($data->created_at,0,10)}}</td>
						<td>{{$data->receipt_code}}</td>
						<td>{{$data->quantity}}</td> 
					</tr>
					@endforeach
					
					@foreach($retur as $datax)
					<tr id="row1">
						<td>{{substr($datax->tanggal_retur,0,10)}}</td>
						<td>{{$datax->packaging_code}}</td>
						<td>{{$datax->quantity_retur}}</td>
					</tr>
					@endforeach
					<tr>
						<th style="text-align:right">Total</th>
						<th style="text-align:center">:</th>
						<th>{{$masuk}}</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-6 col-sm-6  ">
	<div class="x_content">
		<table class="table table-striped">
			<thead>
				<tr>
					<th style="text-align:center" colspan="3">KELUAR</th>
				</tr>
				<tr>
					<th style="text-align:center">TGL</th>
					<th style="text-align:center">KET</th>
					<th style="text-align:center">QTY</th>
				</tr>
			</thead>
			<tbody>
				@foreach($activity as $datay)
				<tr id="row1">
					<td>{{substr($datay->date,0,10)}}</td>
					<td>{{$datay->activity_code}}</td>
					<td>{{$datay->used_quantity}}</td>
				</tr>
				@endforeach
				@foreach($pack as $dataz)
				<tr id="row1">
					<td>{{substr($dataz->date,0,10)}}</td>
					<td>{{$dataz->code}}</td>
					<td>{{$dataz->quantity}}</td>
				</tr>
				@endforeach
				<tr>
					<th style="text-align:right">Total</th>
					<th style="text-align:center">:</th>
					<th>{{$keluar}}</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
<div class="col-md-12 col-sm-12" style="margin-top:-200px">
		<hr>
		<p style="text-align:right;font-size:14pt;color:#000;padding-right:100px"><strong>Sisa = {{$sisa}}</strong> </p>
		<hr>
</div>
@endpush