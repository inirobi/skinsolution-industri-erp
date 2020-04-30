@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Material</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('materials.index')}}">Materials</a></li>
          @if(isset($materials))
            <li>Update Material</li>
          @else
            <li>Add Material</li>
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
        @if(isset($materials))
          <form action="{{ route('materials.update', $materials) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($materials))
                {{ __('Update Material') }}
            @else
                {{ __('Form Material') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Material Kode<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('material_code') is-invalid @enderror" value="{{ old('material_code', $materials->material_code ?? '') }}" name="material_code" required="required" />
            </div>
            @error('material_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Cas Num<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('cas_num') is-invalid @enderror" value="{{ old('cas_num', $materials->cas_num ?? '') }}" type="text" name="cas_num" required='required' />
            </div>
            @error('cas_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Material Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('material_name') is-invalid @enderror" value="{{ old('material_name', $materials->material_name ?? '') }}" name="material_name"required="required" type="text" />
            </div>
            @error('material_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Inci Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='inci_name' rows="3" class="form-control  @error('inci_name') is-invalid @enderror" name="inci_name" required autocomplete="inci_name">{{ old('inci_name', $materials->inci_name ?? '') }}</textarea>
            </div>
            @error('inci_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Stock Minimum<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('stock_minimum') is-invalid @enderror" value="{{ old('stock_minimum', $materials->stock_minimum ?? '') }}" type="number" name="stock_minimum" required='required'>
            </div>
            @error('stock_minimum')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Category<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('category') is-invalid @enderror" value="{{ old('category', $materials->category ?? '') }}" type="text" name="category" required='required'>
            </div>
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Price<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('price') is-invalid @enderror" value="{{ old('price', $materials->price ?? '') }}" type="number" name="price" required='required' />
            </div>
            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($materials))
              <a href="{{ route('materials.index') }}" class="btn btn-danger">Cancel</a>
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