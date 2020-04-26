@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order</h3>
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
        @if(isset($poMaterial))
          <form action="" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($poMaterial))
                {{ __('Update Purchase Order') }}
            @else
                {{ __('Add New Purchase Order') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
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
            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<code>*</code></label>
            <div class="col-md-6 col-sm-6 date">
                <input type="text" class="form-control has-feedback-left" id="single_cal1" aria-describedby="inputSuccess2Status" value="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status" class="sr-only">(success)</span>
            </div>
            @error('cas_num')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Supllier<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="supplier_id">
                  <option value="" >hai</option>
                  <option value="" >hello</option>
              </select>
            </div>
            @error('inci_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Currency<code>*</code></label>
            <div class="col-md-6 col-sm-6">
               <div class="radio radio-info">
                  <input type="radio" value="1"  name="currency" checked="checked"> 
                  <label for="radio1">
                      IDR (Rp)
                  </label>
                </div>
                <div class="radio radio-info">
                  <input type="radio" value="1"  name="currency" checked="checked"> 
                  <label for="radio1">
                      USD ($)
                  </label>
                </div>
            </div>
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Kurs<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('stock_minimum') is-invalid @enderror" value="{{ old('stock_minimum', $materials->stock_minimum ?? '') }}" type="text" name="stock_minimum" required='required'>
            </div>
            @error('stock_minimum')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">PPN<code>*</code></label>
            <div class="col-md-6 col-sm-6">
               <div class="radio radio-info">
                  <input type="radio" value="1"  name="ppn" checked="checked"> 
                  <label for="radio1">
                      Yes
                  </label>
                </div>
                <div class="radio radio-info">
                  <input type="radio" value="0"  name="ppn" checked="checked"> 
                  <label for="radio1">
                      No
                  </label>
                </div>
            </div>
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Description<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='inci_name' rows="3" class="form-control  @error('inci_name') is-invalid @enderror" name="inci_name" required autocomplete="inci_name">{{ old('inci_name', $materials->inci_name ?? '') }}</textarea>
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