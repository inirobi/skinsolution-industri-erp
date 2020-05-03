@extends('layouts.master')

@push('styles')
<!-- bootstrap-daterangepicker -->
<link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
<!-- bootstrap-datetimepicker -->
<link href="{{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Laporan Pengeluaran</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Laporan Pengeluaran</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Laporan Pengeluaran</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="{{route('laporan.store.pengeluaran')}}" novalidate method="POST" enctype="multipart/form-data">
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date Start : </label>
            <div class="col-md-6 col-sm-6">
              <fieldset>
                  <div class="controls">
                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name='date'>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                  </div>
              </fieldset>
            </div>
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date End : </label>
            <div class="col-md-6 col-sm-6">
              <fieldset>
                  <div class="controls">
                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name='date'>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                  </div>
              </fieldset>
            </div>
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jenis PO : </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="jenis_po">
                <option  value="0">-- Pilih PO -- </option>
                <option  value="1">PO Material</option>
                <option  value="2">PO Packaging</option>
                <option  value="3">PO Lain-lain</option>
            </select>
            </div>
          </div><br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Filter</button>
                <a class="btn btn-info pull-right"  data-toggle="modal" href="#"><i class="fa fa-print">Print</i></a>
            </div>
        </form>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Laporan Pengeluaran</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>PO Number</th>
                    <th>Date</th>
                    <th>Supplier Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1; @endphp
                  @foreach($tampMaterial as $data)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$data1->po_num}}</td>
                        <td>{{$data1->po_date}}</td>
                        <td>{{$data1->supplier_name}}</td>
                        <td>{{$data1->quantity}}</td>
                        @if($data1->kurs == NULL)
                            <td>Rp {{number_format($data1->price)}}</td>
                            <td>Rp {{number_format($data1->quantity * $data1->price,2)}}</td>
                            @php $total+=($data1->quantity * $data1->price); @endphp
                        @else
                            <td>Rp {{number_format($data1->kurs * $data1->price)}}</td>
                            <td>Rp {{number_format($data1->quantity * ($data1->kurs * $data1->price),2)}}</td>
                            @php $total+=($data1->quantity * ($data1->kurs * $data1->price)); @endphp
                        @endif
                    </tr>
                  @endforeach
                </tbody>
                <tbody>
                    <tr>
                        <th colspan="6"><strong>Total</strong></th>
                        <td><strong> Rp {{number_format($total,2)}} </strong></td>
                    </tr>
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

@push('scripts')
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection