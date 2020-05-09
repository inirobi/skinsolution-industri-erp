@extends('layouts.master')
@section('site-title')
  Supplier
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Supplier</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('suppliers.index')}}">Suppliers</a></li>
            @if(isset($suppliers))
              <li><a>Update Supplier</a></li>
            @else
              <li><a>Add Supplier</a></li>
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
        @if(isset($suppliers))
          <form action="{{ route('suppliers.update', $suppliers) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($suppliers))
                {{ __('Update Supplier') }}
            @else
                {{ __('Form Supplier') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier Kode<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('supplier_code') is-invalid @enderror" value="{{ old('supplier_code', $suppliers->supplier_code ?? '') }}" name="supplier_code" required="required" />
            </div>
            @error('supplier_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('supplier_name') is-invalid @enderror" value="{{ old('supplier_name', $suppliers->supplier_name ?? '') }}" type="text" name="supplier_name" required='required' />
            </div>
            @error('supplier_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier Mobile</label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control tel @error('supplier_mobile') is-invalid @enderror" value="{{ old('supplier_mobile', $suppliers->supplier_mobile ?? '') }}" name="supplier_mobile"/>
            </div>
            @error('supplier_mobile')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier Address</label>
            <div class="col-md-6 col-sm-6">
              <textarea name='supplier_address' rows="3" class="form-control  @error('supplier_address') is-invalid @enderror" name="supplier_address" autocomplete="supplier_address">{{ old('supplier_address', $suppliers->supplier_address ?? '') }}</textarea>
            </div>
            @error('supplier_address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supplier Email</label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control email @error('supplier_email') is-invalid @enderror" value="{{ old('supplier_email', $suppliers->supplier_email ?? '') }}" type="email" name="supplier_email">
            </div>
            @error('supplier_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Contact Person</label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $suppliers->contact_person ?? '') }}" type="text" name="contact_person">
            </div>
            @error('contact_person')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($suppliers))
              <a href="{{ route('suppliers.index') }}" class="btn btn-danger">Cancel</a>
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