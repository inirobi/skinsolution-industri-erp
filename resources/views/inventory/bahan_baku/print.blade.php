@extends('layouts.master')
@section('site-title')
	Material Print
@endsection
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">KARTU PERSEDIAAN BAHAN BAKU</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Material</th>
					<th>Material</th>
					<th>Unit</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$material->material_code}}</td>
					<td>{{$material->material_name}}</td>
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
						<th style="text-align:center">No. Batch</th>
						<th style="text-align:center">KET</th>														
						<th style="text-align:center">QTY</th>
					</tr>
				</thead>
				<tbody>
					@foreach($purchase as $data)
						<tr id="row1">
							<td>{{substr($data->date,0,10)}}</td>
							<td>{{$data->batch_num}}</td>
							<td>{{$data->purchase_num}}</td>
							<td>{{$data->quantity}}</td>
						</tr>
					@endforeach
					<tr>
						<th style="text-align:right" colspan="2">Total</th>
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
				@foreach($datas as $data)
				<tr id="row1">
					<td>{{$data->tanggal}}</td>
					<td>{{$data->keterangan}}</td>
					<td>{{$data->quantity}}</td>
				</tr>
				@endforeach
				<tr>
					<th style="text-align:right">Total</th>
					<th style="text-align:center">:</th>
					<th>{{$keluar}}</th>
				</tr>
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
    <h3 style="font-size:14pt">KARTU PERSEDIAAN BAHAN BAKU</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Material</th>
					<th>Material</th>
					<th>Unit</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$material->material_code}}</td>
					<td>{{$material->material_name}}</td>
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
						<th style="text-align:center">No. Batch</th>
						<th style="text-align:center">KET</th>														
						<th style="text-align:center">QTY</th>
					</tr>
				</thead>
				<tbody>
					@foreach($purchase as $data)
						<tr id="row1">
							<td>{{substr($data->date,0,10)}}</td>
							<td>{{$data->batch_num}}</td>
							<td>{{$data->purchase_num}}</td>
							<td>{{$data->quantity}}</td>
						</tr>
					@endforeach
					<tr>
						<th style="text-align:right" colspan="2">Total</th>
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
				@foreach($pro_act as $data1)
				<tr id="row1">
					<td>{{substr($data1->date_start,0,10)}}</td>
					<td>{{$data1->activity_code}}</td>
					<td>{{$data1->weighing}}</td>
				</tr>
				@endforeach
				@foreach($pro_mat as $data2)
				<tr id="row1">
					<td>{{substr($data2->date,0,10)}}</td>
					<td>{{$data2->code}}</td>
					<td>{{$data2->quantity}}</td>
				</tr>
				@endforeach
				@foreach($formula as $data3)
				<tr id="row1">
					<td>{{substr($data3->created_at,0,10)}}</td>
					<td>{{$data3->formula_num}}</td>
					<td>{{$data3->weighing}}</td>
				</tr>
				@endforeach
				<tr>
					<th style="text-align:right">Total</th>
					<th style="text-align:center">:</th>
					<th>{{$keluar}}</th>
				</tr>
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