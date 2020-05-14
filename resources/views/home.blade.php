@extends('layouts.master')
@section('site-title')
  Home
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ENTERPRISE RESOURCE PLANNING <br><small>PT. Skinsolution Industri</small></h2>
        <div class="filter">
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12 col-sm-12 ">
          <div class="demo-container" style="height:280px">
            <div id="chart_plot_02" class="demo-placeholder"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Flot -->
<script src="{{ asset('assets/vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{ asset('assets/vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('assets/vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{ asset('assets/vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{ asset('assets/vendors/Flot/jquery.flot.resize.js')}}"></script>
<!-- DateJS -->
<script src="{{ asset('assets/vendors/DateJS/build/date.js')}}"></script>
@endpush