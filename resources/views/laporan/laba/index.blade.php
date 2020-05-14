@extends('layouts.master')
@section('site-title')
  Laba
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Laporan Laba</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a>Laporan Laba</a></li>
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
        <h2>Laporan</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="{{route('laba.store')}}" novalidate method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Date Start : </label>
                <div class="col-md-6 col-sm-6">
                  <div class="controls">
                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                      <input value="" type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name='date'>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Date End : </label>
                <div class="col-md-6 col-sm-6">
                  <div class="controls">
                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                      <input value="" type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="Date" aria-describedby="date" name='date2'>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="modal-footer">
                  <button type="reset" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                  <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(!empty($masuk))
    @php $tot1=0; $tot2=0; @endphp
      @foreach($masuk as $dd)
          @php $tot1=$tot1 + $dd->money; @endphp
      @endforeach
    @foreach($kel as $ddd)
      @php $tot2=$tot2 + $ddd->money; @endphp
    @endforeach
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_content">
          <form action="#" novalidate method="POST" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Periode Awal : </label>
            <div class="col-md-6 col-sm-6">
              <div class="controls">
                <input type="hidden" name='awal' value="{{$aw}}">
                <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                  <input value="{{$aw}}" type="text" class="form-control has-feedback-left" disabled id="single_cal4" placeholder="Date" aria-describedby="date">
                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Periode Akhir : </label>
            <div class="col-md-6 col-sm-6">
              <div class="controls">
              <input type="hidden" name='akh' value="{{$akh}}">
                <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                  <input value="{{$akh}}" type="text" class="form-control has-feedback-left" disabled id="single_cal3" placeholder="Date" aria-describedby="date">
                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Total Pemasukkan :</label>
            <div class="col-md-6 col-sm-6">
              <label class="col-form-label" style="font-size:12pt;">Rp {{number_format($tot1,2)}}</label>
              <input class="form-control" type="hidden" name="masuk"  readonly value="Rp {{number_format($tot1,2)}}"/>
            </div>
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align"> Pengeluaran :</label>
            <div class="col-md-6 col-sm-6">
              <label class="col-form-label" style="font-size:12pt;">Rp {{number_format($tot2,2)}}</label>
              <input class="form-control" type="hidden" name="keluar" readonly value="Rp {{number_format($tot2,2)}}"/>
            </div>
          </div>
          
          <hr style="color:green">

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align" style="font-size:14pt;"> <strong>Laba :</strong> </label>
            <div class="col-md-6 col-sm-6">
              <label class="col-form-label" style="font-size:14pt;"><strong>Rp {{number_format($tot1-$tot2,2)}}</strong></label>
              <input class="form-control" type="hidden" name="laba" readonly value="Rp {{number_format($tot1-$tot2,2)}}"/>
            </div>
          </div>

          <div class="ln_solid">
            <div class="form-group">
            <br>
                <button onclick="javascript:window.print()" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
@push('scripts')
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection

@push('print')
@if(!empty($masuk))
    @php $tot1=0; $tot2=0; @endphp
      @foreach($masuk as $dd)
          @php $tot1=$tot1 + $dd->money; @endphp
      @endforeach
    @foreach($kel as $ddd)
      @php $tot2=$tot2 + $ddd->money; @endphp
    @endforeach
<div class="page-title">
  <div class="title_left">
    <h3 style="font-size:14pt">LABA</h3><br><br><br>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>Periode Awal</th>
					<th>Periode Akhir</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$aw}}</td>
					<td>{{$akh}}</td>
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
						<th>Total Pemasukkan</th>
						<th>Total Pengeluaran</th>
					</tr>
				</thead>
				<tbody>
						<tr>
							<td>Rp {{number_format($tot1,2)}}</td>
							<td>Rp {{number_format($tot2,2)}}</td>
					<tr>
						<th style="text-align:right">Laba : </th>
						<th>Rp {{number_format($tot1-$tot2,2)}}</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
@endif
@endpush