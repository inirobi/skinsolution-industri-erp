@extends('layouts.master')

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
          @if(isset($data))
            <li>Update Packaging</li>
          @else
            <li>Add Packaging</li>
          @endif
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
                @if(isset($data))
                    <form action="{{ route('packagings.update', $data) }}" novalidate method="POST" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form action="{{ route('packagings.store') }}" method="POST" enctype="multipart/form-data">
                @endif

                        @csrf
                        <p>Wajib disi <code>*</code>
                        </p>
                        <span class="section">
                            @if(isset($data))
                            {{ __('Update Packaging') }}
                            @else
                            {{ __('Form Packaging') }}
                            @endif
                        </span>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging
                                Code<code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control @error('packaging_code') is-invalid @enderror"
                                    value="{{ old('packaging_code', $data->packaging_code ?? '') }}"
                                    name="packaging_code" required="required" autofocus placeholder="Packaging Code"/>
                            </div>
                            @error('packaging_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Category<code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control @error('category') is-invalid @enderror"
                                    value="{{ old('category', $data->category ?? '') }}" name="category"
                                    required="required" placeholder="Category"/>
                            </div>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging
                                Name<code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control  @error('packaging_name') is-invalid @enderror"
                                    value="{{ old('packaging_name', $data->packaging_name ?? '') }}" type="text"
                                    name="packaging_name" required='required' placeholder="Packaging Name"/>
                            </div>
                            @error('packaging_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Packaging Type <code>*</code></label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="packaging_type" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-customer">
                                        <input type="radio" value="CS" id="packaging_type" name="packaging_type"
                                            checked="checked" class="join-btn">
                                        &nbsp; Customer
                                    </label>
                                    <label class="btn btn-secondary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-supplier">
                                        <input type="radio" value="SS" id="packaging_type" name="packaging_type"
                                            class="join-btn">
                                        &nbsp; Supplier
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Vendor <code>*</code></label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="cs">
                                    <select class="form-control" name="vendor" id="vendor">
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Stock Minimum
                                <code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control  @error('stock_minimum') is-invalid @enderror"
                                    value="{{ old('stock_minimum', $data->stock_minimum ?? '') }}" type="number"
                                    name="stock_minimum" required='required' min="1" placeholder="Stock Minimum"/>
                            </div>
                            @error('stock_minimum')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Price <code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control  @error('price') is-invalid @enderror"
                                    value="{{ old('price', $data->price ?? '') }}" type="number" name="price"
                                    required='required' min="0" placeholder="Price"/>
                            </div>
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" onclick="javascript:history.back()">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@include('layouts.validasi_footer')

@push('scripts')
<script>
    $.get('{{url("packagings/customer/ajax")}}', function (data) {
        $('#vendor').empty();
        $.each(data, function (index, subcatObj) {
            $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj.customer_name +
                '</option>')
        });
    });


    $('input[type=radio][name=packaging_type]').change(function () {
        var source = this.value;

        if (source == "SS") {
            $('#btn-customer').attr('class', 'btn btn-secondary');
            $('#btn-supplier').attr('class', 'btn btn-primary');
            $.get('{{url("packagings/supplier/ajax")}}', function (data) {
                $('#vendor').empty();
                $.each(data, function (index, subcatObj) {
                    $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj
                        .supplier_name + '</option>')
                });
            });


        }
        if (source == "CS") {
            $('#btn-customer').attr('class', 'btn btn-primary');
            $('#btn-supplier').attr('class', 'btn btn-secondary');
            $.get('{{url("packagings/customer/ajax")}}', function (data) {
                $('#vendor').empty();
                $.each(data, function (index, subcatObj) {
                    $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj
                        .customer_name + '</option>')
                });
            });
        }




    });

</script>
@endpush
@endsection
