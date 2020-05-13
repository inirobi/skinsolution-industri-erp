@extends('layouts.master')
@section('site-title')
  Pengeluaran Packaging
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Add New Pengeluaran Packaging</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('pengeluaran_packaging.index')}}">Pengeluaran Packaging</a></li>
          @if(isset($packout))
            <li>Update Pengeluaran Packaging</li>
          @else
            <li>Add Pengeluaran Packaging</li>
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
        @if(isset($packout))
          <form action="{{ route('pengeluaran_packaging.update', $packout->id) }}" novalidate method="POST" enctype="multipart/form-data">
          @method('PUT')
        @else
            <form action="{{ route('pengeluaran_packaging.store') }}" method="POST" enctype="multipart/form-data">          
        @endif
        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($packout))
              {{ __('Update Pengeluaran Packaging') }}
            @else
              {{ __('Add Pengeluaran Packaging') }}
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Code<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('code') is-invalid @enderror" @if(isset($packout)) disabled @endif value="{{ old('code', $packout->code ?? '') }}" name="code" required="required" />
            </div>
            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Date : </label>
              <fieldset>
              <div class="control-group">
                  <div class="controls">
                      <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                          <input autocomplete='off' type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{ old('date', $packout->date ?? '') }}" name="date">
                          <span class="fa fa-calendar-o form-control-feedback left @error('date') is-invalid @enderror" aria-hidden="true"></span>
                      </div>
                      
                      @error('date')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                  </div>
              </div>
              </fieldset>
          </div>
          <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging <code>*</code></label>
              <div class="col-md-6 col-sm-6">
                  <select class="form-control @error('packaging_id') is-invalid @enderror" name="packaging_id">
                  @if(isset($packout))
                    @foreach($packaging as $bv)
                      @if($bv->category!="sticker" && $bv->category!="Stiker" && $bv->category!="Sticker" && $bv->category!="box" && $bv->category!="Box")
                        <option @if($bv->id == $packout->packaging_id) selected @endif value="{{$bv->id}}" >{{$bv->category}} - {{$bv->packaging_name}}</option>
                      @endif
                    @endforeach
                  @else
                    @foreach($packaging as $bv)
                      @if($bv->category!="sticker" && $bv->category!="Stiker" && $bv->category!="Sticker" && $bv->category!="box" && $bv->category!="Box")
                        <option value="{{$bv->id}}" >{{$bv->category}} - {{$bv->packaging_name}}</option>
                      @endif
                    @endforeach
                  @endif
                  </select>
              </div>
              @error('packaging_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Quantity<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('quantity') is-invalid @enderror" value="{{ old('quantity', $packout->quantity ?? '') }}" type="number" name="quantity" required='required'>
            </div>
            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Keterangan</label>
            <div class="col-md-6 col-sm-6">
              <textarea name='keterangan' rows="3" class="form-control  " name="keterangan" autocomplete="keterangan">{{ old('keterangan', $packout->keterangan ?? '') }}</textarea>
            </div>
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($packout))
              <a href="{{ route('pengeluaran_packaging.index') }}" class="btn btn-danger">Cancel</a>
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

@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush


@push('scripts')
</script>
    <!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>


@endpush
@endsection