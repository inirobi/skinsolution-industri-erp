@extends('layouts.master')
@section('site-title')
	Formula Print
@endsection
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">FORMULA</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Product</th>
					<th>Product</th>
					<th>Customer</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$product->product_code}}</td>
					<td>{{$product->product_name}}</td>
					<td>{{$product->customer->customer_name}}</td>
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
	<div class="col-md-12 ">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr >
						<th>Created At</th>
						<th>Material</th>
						<th>Source Material</th>
						<th>Quantity Material (%)</th>														
					</tr>
				</thead>
				<tbody>
				@foreach($formula_view as $data)
					<tr id="row1">
						<td> {{$data->created_at}}</td>
						<td> 
							@if (!$data->source_material) {{$data->sampleMaterial->material_name}} @endif
							@if ($data->source_material) {{$data->material->material_name}} @endif                                                     
						</td>
						<td>
							@if (!$data->source_material) From Sample @endif
							@if ($data->source_material) From Material @endif
						</td>
						<td> {{$data->quantity}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
<div class="clearfix"></div>

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
    <h3 style="font-size:14pt">FORMULA</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Product</th>
					<th>Product</th>
					<th>Customer</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$product->product_code}}</td>
					<td>{{$product->product_name}}</td>
					<td>{{$product->customer->customer_name}}</td>
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
	<div class="col-md-12 ">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr >
						<th>Created At</th>
						<th>Material</th>
						<th>Source Material</th>
						<th>Quantity Material (%)</th>														
					</tr>
				</thead>
				<tbody>
				@foreach($formula_view as $data)
					<tr id="row1">
						<td> {{$data->created_at}}</td>
						<td> 
							@if (!$data->source_material) {{$data->sampleMaterial->material_name}} @endif
							@if ($data->source_material) {{$data->material->material_name}} @endif                                                     
						</td>
						<td>
							@if (!$data->source_material) From Sample @endif
							@if ($data->source_material) From Material @endif
						</td>
						<td> {{$data->quantity}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
@endpush