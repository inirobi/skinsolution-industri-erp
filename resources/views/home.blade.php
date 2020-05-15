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
      @if(Auth::user()->role == 0)
      <div class="x_content">
        <div class="col-md-9 col-sm-9 ">
          <div class="demo-container" style="height:280px">
            <div id="chart_plot_02" class="demo-placeholder"></div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 ">
          <ul class="list-unstyled timeline">
            <li>
              <div class="block">
                <div class="tags">
                  <a href="" class="tag">
                    <span>Customers</span>
                  </a>
                </div>
                <div class="block_content">
                  <h2 class="title">
                      <a>{{$total_customer}}</a>
                  </h2>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="tags">
                  <a href="" class="tag">
                    <span>Suppliers</span>
                  </a>
                </div>
                <div class="block_content">
                  <h2 class="title">
                      <a>{{$total_supplier}}</a>
                  </h2>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="tags">
                  <a href="" class="tag">
                    <span>Materials</span>
                  </a>
                </div>
                <div class="block_content">
                  <h2 class="title">
                      <a>{{$total_material}}</a>
                  </h2>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="tags">
                  <a href="" class="tag">
                    <span>Product</span>
                  </a>
                </div>
                <div class="block_content">
                  <h2 class="title">
                      <a>{{$total_product}}</a>
                  </h2>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      @endif
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
<!-- Chart.js -->
<script src="{{ asset('assets/vendors/Chart.js/dist/Chart.min.js')}}"></script>
<!-- jQuery Sparklines -->
<script src="{{ asset('assets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- morris.js -->
<script src="{{ asset('assets/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('assets/vendors/morris.js/morris.min.js')}}"></script>
<!-- gauge.js -->
<script src="{{ asset('assets/vendors/gauge.js/dist/gauge.min.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- Skycons -->
<script src="{{ asset('assets/vendors/skycons/skycons.js')}}"></script>
<!-- Flot plugins -->
<script src="{{ asset('assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{ asset('assets/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{ asset('assets/vendors/flot.curvedlines/curvedLines.js')}}"></script>
<!-- DateJS -->
<script src="{{ asset('assets/vendors/DateJS/build/date.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endpush