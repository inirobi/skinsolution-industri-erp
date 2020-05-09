@extends('layouts.master')
@section('site-title')
  LeftOver
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>LeftOver Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>LeftOver Lists</li>
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
        <h2>LeftOvers</h2>
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
                    <th>PO Number</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1 @endphp
                  @foreach($po as $data)
                  <tr>
                    <td>{{$no++}}</td>
                    <td> {{$data->po_num}} </td>
                    <td> {{$data->customer_name}}</td>
                    <td> {{$data->date}}</td>
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