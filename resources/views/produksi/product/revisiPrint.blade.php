@extends('layouts.master')
@section('site-title')
    Procedure
@endsection
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">PROCEDURE</h3><br><br><br>
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
						<th style="text-align:center">PROCEDURE</th>													
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> 
                            <pre>{{$revision->prosedur}}</pre>
                        </td>
					</tr>
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
    <h3 style="font-size:14pt">PROCEDURE</h3><br><br><br>
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
						<th style="text-align:center">PROCEDURE</th>													
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> 
                            <pre>{{$revision->prosedur}}</pre>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
@endpush