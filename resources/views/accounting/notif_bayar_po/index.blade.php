@extends('layouts.master')
@section('site-title')
  Payment
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Payment Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Payments</li>
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
          <h2>Payments</h2>
          <button onclick="javascript:window.print()" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print</button>
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
                <th>Description</th>
                <th>Supplier</th>
                <th>Tanggal PO</th>
                <th>Tanggal Jatuh Tempo</th>
                <th> Money</th>
              </tr>
            </thead>
            <tbody>
            @if(!empty($lain))
              @foreach($lain as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data->nama_barang}}</td>
                <td>{{$data->supplier_name}}</td>
                <td> {{$data->po_date}} </td>
                <td> {{$data->tempo}} </td>
                <td>Rp. {{number_format($data->quantity * $data->price,2)}}</td>
              </tr>
              @endforeach
            
            @elseif(!empty($pack))
              @foreach($pack as $data2)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data2->packaging_name}}</td>
                <td>{{$data2->supplier_name}}</td>
                <td> {{$data2->po_date}} </td>
                <td> {{$data2->tempo}} </td>
                <td>Rp. {{number_format($data2->quantity * $data2->price,2)}}</td>
              </tr>
              @endforeach
            
            @elseif(!empty($mat))
              @foreach($mat as $data2)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{$data2->packaging_name}}</td>
                <td>{{$data2->supplier_name}}</td>
                <td> {{$data2->po_date}} </td>
                <td> {{$data2->tempo}} </td>
                <td>Rp. {{number_format($data2->quantity * $data2->price,2)}}</td>
              </tr>
              @endforeach
            @endif
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
    <h3>Materials List</h3>
  </div>
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div style='float:right;text-align:right'>
			<img src="{{asset('assets/src/img/logo-skin-care.png')}}" />
			<br><br>
			<h2 style="font-size:14pt">CV SKIN SOLUTION BEAUTY CARE INDONESIA <br>
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
                <th>No</th>
                <th>Description</th>
                <th>Supplier</th>
                <th>Tanggal PO</th>
                <th>Tanggal Jatuh Tempo</th>
                <th> Money</th>
						</tr>
					</thead>
					<tbody>
            @php 
              $nomor = 1;
              $total = 0;
            @endphp
          @if(!empty($lain))
              @foreach($lain as $data)
              <tr>
                <td>{{ $nomor++ }}</td>
                <td>{{$data->nama_barang}}</td>
                <td>{{$data->supplier_name}}</td>
                <td> {{$data->po_date}} </td>
                <td> {{$data->tempo}} </td>
                <td>Rp. {{number_format($data->quantity * $data->price,2)}}</td>
                @php $total+= ($data->quantity * $data->price); @endphp
              </tr>
              @endforeach
            
            @elseif(!empty($pack))
              @foreach($pack as $data2)
              <tr>
                <td>{{ $nomor++ }}</td>
                <td>{{$data2->packaging_name}}</td>
                <td>{{$data2->supplier_name}}</td>
                <td> {{$data2->po_date}} </td>
                <td> {{$data2->tempo}} </td>
                <td>Rp. {{number_format($data2->quantity * $data2->price,2)}}</td>
                @php $total+= ($data2->quantity * $data2->price); @endphp
              </tr>
              @endforeach
            
            @elseif(!empty($mat))
              @foreach($mat as $data2)
              <tr>
                <td>{{ $nomor++ }}</td>
                <td>{{$data2->packaging_name}}</td>
                <td>{{$data2->supplier_name}}</td>
                <td> {{$data2->po_date}} </td>
                <td> {{$data2->tempo}} </td>
                <td>Rp. {{number_format($data2->quantity * $data2->price,2)}}</td>
                @php $total+= ($data3->quantity * $data3->price); @endphp
              </tr>
              @endforeach
            @endif
            <tr id="row1">
                <th colspan="5" style="text-align:center">Total</th>
                <th>Rp. {{number_format($total,2)}}</th>
            </tr>
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