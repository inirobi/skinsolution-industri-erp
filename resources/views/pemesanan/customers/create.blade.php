@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Data Customer</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_content">
        @if(isset($customers))
          <form action="{{ route('customers.update', $customers) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($customers))
                {{ __('Update Customer') }}
            @else
                {{ __('Form Customer') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Kode<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('customer_code') is-invalid @enderror" value="{{ old('customer_code', $customers->customer_code ?? '') }}" name="customer_code" required="required" />
            </div>
            @error('customer_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $customers->customer_name ?? '') }}" type="text" name="customer_name" required='required' />
            </div>
            @error('customer_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Mobile<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control tel @error('customer_mobile') is-invalid @enderror" value="{{ old('customer_mobile', $customers->customer_mobile ?? '') }}" name="customer_mobile"required="required" type="tel" data-validate-length-range="8,20"/>
            </div>
            @error('customer_mobile')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Address<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='customer_address' rows="3" class="form-control  @error('customer_address') is-invalid @enderror" name="customer_address" required autocomplete="customer_address">{{ old('customer_address', $customers->customer_address ?? '') }}</textarea>
            </div>
            @error('customer_address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Email<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control email @error('customer_email') is-invalid @enderror" value="{{ old('customer_email', $customers->customer_email ?? '') }}" type="email" name="customer_email" required='required'>
            </div>
            @error('customer_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($customers))
              <a href="{{ route('customers.index') }}" class="btn btn-danger">Cancel</a>
            @else
              <button type="reset" class="btn btn-success">Reset</button>
            @endif
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

@include('layouts.validasi_footer')
@endsection