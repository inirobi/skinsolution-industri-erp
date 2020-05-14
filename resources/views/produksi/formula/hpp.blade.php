@extends('layouts.master')
@section('site-title')
	HPP
@endsection
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">HPP</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Formula</th>
					<th>Customer</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($product))
				<tr>
					<td>{{$product->formula->formula_num}}</td>
					<td>{{$product->customer->customer_name}}</td>
				</tr>
				@else
				<tr>
					<td></td>
					<td></td>
				</tr>
				@endif
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
	<div class="col-md-12">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr >
						<th>Material</th>
						<th>Quantity</th>
						<th>Price (Rp)</th>														
						<th>Total Price (Rp)</th>
					</tr>
				</thead>
				<tbody>
					@php 
						$HPP = 0;
					@endphp
					@if(!empty($formula))
					@foreach($formula as $dt)
						<tr id="row1">
							@if($dt->source_material) 
							@php  
								$material = App\Material::where('id', $dt->material_id)->first();
								$HPP = $HPP + ($material->price * ($dt->quantity/100));
								$total = ($material->price * ($dt->quantity/100));
							@endphp
								<td> {{$material->material_name}} </td>
								<td> {{$dt->quantity}}</td>
								<td> {{number_format($material->price,2)}}</td>
								<td> {{number_format($total,2)}} </td>
							@endif
							@if(!$dt->source_material) 
							@php 
								$material = App\SampleMaterial::where('id', $dt->material_id)->first();
								$HPP = $HPP + ($material->price * ($dt->quantity/100));
								$total = ($material->price * ($dt->quantity/100));																																	
							@endphp
								<td> {{$material->material_name}} </td>
								<td> {{$dt->quantity}}</td>
								<td> {{number_format($material->price,2)}}</td>
								<td> {{number_format($total,2)}} </td>
							@endif
						</tr>
					@endforeach
					@endif
				</tbody>
				<tfoot>
					<tr class="txt-dark">
						<td> HPP </td>
						<td>   </td>
						<td>   </td>
						<td > {{number_format($HPP,2)}} </td>
					</tr>
					<tr class="txt-dark">
						<td> Biaya Lain-Lain </td>
						<td> 20%  </td>
						<td>   </td>
						<td > {{number_format($HPP*0.2,2)}} </td>
					</tr>
					<tr class="txt-dark">
						<th>Total HPP</th>
						<td>   </td>
						<td>   </td>
						<th > {{number_format($HPP+($HPP*0.2),2)}} </th>
					</tr>
				</tfoot>
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
    <h3 style="font-size:14pt">HPP</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Code Formula</th>
					<th>Customer</th>>
				</tr>
			</thead>
			<tbody>
				@if(!empty($product))
				<tr>
					<td>{{$product->formula->formula_num}}</td>
					<td>{{$product->customer->customer_name}}</td>
				</tr>
				@else
				<tr>
					<td></td>
					<td></td>
				</tr>
				@endif
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
	<div class="col-md-12">
		<div class="x_content">
			<table class="table table-striped">
				<thead>
					<tr >
						<th>Material</th>
						<th>Quantity</th>
						<th>Price (Rp)</th>														
						<th> Price (Rp)</th>
					</tr>
				</thead>
				<tbody>
					@php 
						$HPP = 0;
					@endphp
					@if(!empty($formula))
					@foreach($formula as $dt)
						<tr id="row1">
							@if($dt->source_material) 
							@php  
								$material = App\Material::where('id', $dt->material_id)->first();
								$HPP = $HPP + ($material->price * ($dt->quantity/100));
								$total = ($material->price * ($dt->quantity/100));
							@endphp
								<td> {{$material->material_name}} </td>
								<td> {{$dt->quantity}}</td>
								<td> {{number_format($material->price,2)}}</td>
								<td> {{number_format($total,2)}} </td>
							@endif
							@if(!$dt->source_material) 
							@php 
								$material = App\SampleMaterial::where('id', $dt->material_id)->first();
								$HPP = $HPP + ($material->price * ($dt->quantity/100));
								$total = ($material->price * ($dt->quantity/100));																																	
							@endphp
								<td> {{$material->material_name}} </td>
								<td> {{$dt->quantity}}</td>
								<td> {{number_format($material->price,2)}}</td>
								<td> {{number_format($total,2)}} </td>
							@endif
						</tr>
					@endforeach
					@endif
				</tbody>
				<tfoot>
					<tr class="txt-dark">
						<td> HPP </td>
						<td>   </td>
						<td>   </td>
						<td > {{number_format($HPP,2)}} </td>
					</tr>
					<tr class="txt-dark">
						<td> Biaya Lain-Lain </td>
						<td> 20%  </td>
						<td>   </td>
						<td > {{number_format($HPP*0.2,2)}} </td>
					</tr>
					<tr class="txt-dark">
						<th> Total HPP</th>
						<td>   </td>
						<td>   </td>
						<th>{{number_format($HPP+($HPP*0.2),2)}}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
</div>
@endpush