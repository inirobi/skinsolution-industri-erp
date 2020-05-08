@extends('layouts.export.app')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@push('styles')
	<style>
		.kepala{
			border: 1px solid black;
			border-collapse: collapse;
			border-spacing: 5px;
		}
		.badan{
			border: 1px solid black;
			border-collapse: collapse;
			padding: 15px;
		}
	</style>
@endpush

@section('content')
<div id="content">
	<table width="100%">
		<tr>
			<td>
				<table class="kepala">
					<tr>
						<th class="badan">No</th>
						<th class="badan">Nama</th>
						<th class="badan">Alamat</th>
						<th class="badan">Usia</th>
					</tr>
					<tr>
						<td class="badan">1</td>
						<td class="badan">Andi Saputra</td>
						<td class="badan">Magelang</td>
						<td class="badan">21</td>
					</tr>
					<tr>
						<td class="badan">2</td>
						<td class="badan">Budi Budiman</td>
						<td class="badan">Jakarta</td>
						<td class="badan">24</td>
					</tr>
				</table>
			</td>
			<td style="text-align:right">
				<p>CV SKIN SOLUTION BEAUTY CARE INDONESIA</p>
				<p style="font-size:11pt;color:#696969; ">
					Jalan Waruga Jaya No. 47, Ciwaruga <br>
					Parongpong, 40559 <br>
					West Java, Indonesia <br>
					P:(022) 820-270-55
				</p>
			</td>
		</tr>
	</table>
	<br><br>
	<div style="width:49%;float:right;">
		<table class="kepala" style="width:100%">
			<tr>
				<th class="badan" colspan="4">Kelur</th>
			</tr>
			<tr>
				<th class="badan">No</th>
				<th class="badan">Nama</th>
				<th class="badan">Alamat</th>
				<th class="badan">Usia</th>
			</tr>
			<tr>
				<td class="badan">1</td>
				<td class="badan">Andi Saputra</td>
				<td class="badan">Magelang</td>
				<td class="badan">21</td>
			</tr>
			<tr>
				<td class="badan">2</td>
				<td class="badan">Budi Budiman</td>
				<td class="badan">Jakarta</td>
				<td class="badan">24</td>
			</tr>
		</table>
	</div>
	<div style="width:49%;">
		<table class="kepala" style="width:100%">
			<tr>
				<th class="badan" colspan="4">Masuk</th>
			</tr>
			<tr>
				<th class="badan">No</th>
				<th class="badan">Nama</th>
				<th class="badan">Alamat</th>
				<th class="badan">Usia</th>
			</tr>
			<tr>
				<td class="badan">1</td>
				<td class="badan">Andi Saputra</td>
				<td class="badan">Magelang</td>
				<td class="badan">21</td>
			</tr>
			<tr>
				<td class="badan">2</td>
				<td class="badan">Budi Budiman</td>
				<td class="badan">Jakarta</td>
				<td class="badan">24</td>
			</tr>
			<tr>
				<td class="badan">1</td>
				<td class="badan">Andi Saputra</td>
				<td class="badan">Magelang</td>
				<td class="badan">21</td>
			</tr>
			<tr>
				<td class="badan">2</td>
				<td class="badan">Budi Budiman</td>
				<td class="badan">Jakarta</td>
				<td class="badan">24</td>
			</tr>
		</table>
	</div>
	<br><br>
</div>
@endsection
