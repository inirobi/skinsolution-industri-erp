@extends('layouts.master')
@section('site-title')
    Packaging
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3>Packaging</h3>
    </div>
    <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('packagings.index')}}">Packagings</a></li>
            <li>Detail Packaging</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <span class="section">Detail Packaging</span>
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control @error('packaging_code') is-invalid @enderror"
                            value="{{ old('packaging_code', $data->packaging_code ?? '') }}"
                            name="packaging_code" disabled autofocus placeholder="Packaging Code"/>
                    </div>
                </div>
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Category</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category', $data->category ?? '') }}" name="category"
                            disabled placeholder="Category"/>
                    </div>
                </div>
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging
                        Name</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control  @error('packaging_name') is-invalid @enderror"
                            value="{{ old('packaging_name', $data->packaging_name ?? '') }}" type="text"
                            name="packaging_name" disabled placeholder="Packaging Name"/>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">Packaging Type </label>
                    <input type="hidden" id="cekType" value="{{$data->packaging_type}}">
                    <div class="col-md-6 col-sm-6 ">
                        <div id="packaging_type" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default" id="btn-customer">
                                <input disabled type="radio" value="CS" id="packaging_type" name="packaging_type"
                                    checked="checked" class="join-btn">
                                &nbsp; Customer
                            </label>
                            <label class="btn btn-secondary" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default" id="btn-supplier">
                                <input type="radio" disabled value="SS" id="packaging_type" name="packaging_type"
                                    class="join-btn">
                                &nbsp; Supplier
                            </label>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">Vendor </label>
                    <div class="col-md-6 col-sm-6 ">
                        @if($data->packaging_type == "CS")
                            <input class="form-control" value="{{ $data->customer->customer_name }}" disabled type="text"/>
                        @elseif($data->packaging_type == "SS")
                            <input class="form-control" value="{{ $data->supplier->supplier_name }}" disabled type="text"/>
                        @endif
                    </div>
                </div>


                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Stock Minimum
                        </label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control  @error('stock_minimum') is-invalid @enderror"
                            value="{{ old('stock_minimum', $data->stock_minimum ?? '') }}" type="number"
                            name="stock_minimum" disabled min="1" placeholder="Stock Minimum"/>
                    </div>
                </div>

                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Price </label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control  @error('price') is-invalid @enderror"
                            value="{{ old('price', $data->price ?? '') }}" type="number" name="price"
                            disabled min="0" placeholder="Price"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="javascript:history.back()">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@include('layouts.validasi_footer')


@push('scripts')
<script>
var source = $('#cekType').val();

if (source == "SS") {
    $('#btn-customer').attr('class', 'btn btn-secondary');
    $('#btn-supplier').attr('class', 'btn btn-primary');
}
if (source == "CS") {
    $('#btn-customer').attr('class', 'btn btn-primary');
    $('#btn-supplier').attr('class', 'btn btn-secondary');
}
</script>
@endpush
@endsection
