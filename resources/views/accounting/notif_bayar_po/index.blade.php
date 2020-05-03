@extends('layouts.master')

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
          <button type="submit" id="print" data-dismiss="modal" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print</button>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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