@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Data Principals</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('principals.index')}}">Principals</a></li>
            @if(isset($principals))
              <li><a>Update Principals</a></li>
            @else
              <li><a>Add Principals</a></li>
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
        @if(isset($principals))
          <form action="{{ route('principals.update', $principals) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('principals.store') }}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($principals))
                {{ __('Update principal') }}
            @else
                {{ __('Form principal') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Principal Kode<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('principal_code') is-invalid @enderror" value="{{ old('principal_code', $principals->principal_code ?? '') }}" name="principal_code" required="required" />
            </div>
            @error('principal_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('name') is-invalid @enderror" value="{{ old('name', $principals->name ?? '') }}" type="text" name="name" required='required' />
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Address<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='address' rows="3" class="form-control  @error('address') is-invalid @enderror" name="address" required autocomplete="address">{{ old('address', $principals->address ?? '') }}</textarea>
            </div>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Country<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('country') is-invalid @enderror" value="{{ old('country', $principals->country ?? '') }}" type="text" name="country" required='required'>
            </div>
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($principals))
              <a href="{{ route('principals.index') }}" class="btn btn-danger">Cancel</a>
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