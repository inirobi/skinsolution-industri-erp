@extends('layouts.master')
@section('site-title')
  @if(isset($sts))
      {{ __('Pengeluaran Hasil Labelling') }}
  @else
      {{ __('Pengeluaran Labelling') }}
  @endif
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>
      @if(isset($sts))
          {{ __('Add New Pengeluaran Hasil Labelling') }}
      @else
          {{ __('Add New Pengeluaran Labelling') }}
      @endif
    </h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            @if(isset($sts))
              <li><a href="{{route('pengeluaran_labelling2.index2')}}">Pengeluaran Hasil Labelling Lists</a></li>
            @else
              <li><a href="{{route('pengeluaran_labelling.index')}}">Pengeluaran Labelling Lists</a></li>
            @endif
            <li>
              @if(isset($matout))
                @if(isset($sts))
                  {{ __('Update Pengeluaran Hasil Labelling') }}
                @else
                  {{ __('Update Pengeluaran Labelling') }}
                @endif
              @else
                @if(isset($sts))
                  {{ __('Form Pengeluaran Hasil Labelling') }}
                @else
                  {{ __('Form Pengeluaran Labelling') }}
                @endif
              @endif
            </li>
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
        @if(isset($matout))
          @if(isset($sts))
            <form action="{{ route('pengeluaran_labelling2.update2', $matout->id) }}" novalidate method="POST" enctype="multipart/form-data">
          @else
            <form action="{{ route('pengeluaran_labelling.update', $matout->id) }}" novalidate method="POST" enctype="multipart/form-data">
          @endif
          @method('PUT')
        @else
          @if(isset($sts))
            <form action="{{ route('pengeluaran_labelling2.store2') }}" method="POST" enctype="multipart/form-data">
          @else
            <form action="{{ route('pengeluaran_labelling.store') }}" method="POST" enctype="multipart/form-data">
          @endif
        @endif

        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            @if(isset($matout))
              @if(isset($sts))
                {{ __('Update Pengeluaran Hasil Labelling') }}
              @else
                {{ __('Update Pengeluaran Labelling') }}
              @endif
            @else
              @if(isset($sts))
                {{ __('Form Pengeluaran Hasil Labelling') }}
              @else
                {{ __('Form Pengeluaran Labelling') }}
              @endif
            @endif
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Code<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('code') is-invalid @enderror" @if(isset($matout)) disabled @endif value="{{ old('code', $matout->code ?? '') }}" name="code" required="required" />
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
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{ old('date', $matout->date ?? '') }}" name="date">
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
          @if(isset($sts))
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Product <code>*</code></label>
                <div class="col-md-6 col-sm-6">
                    <select class="form-control @error('labelling_id') is-invalid @enderror" name="labelling_id">
                    @if(isset($matout))
                        @foreach($product as $d)
                            <option @if($d->id == $matout->product_id) selected @endif value="{{$d->id}}" >{{$d->product_name}}</option>
                        @endforeach
                    @else
                        @foreach($product as $d)
                            <option value="{{$d->id}}" >{{$d->product_name}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
                @error('labelling_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          @else
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging <code>*</code></label>
                <div class="col-md-6 col-sm-6">
                    <select class="form-control @error('labelling_id') is-invalid @enderror" name="labelling_id">
                    @if(isset($matout))
                        @foreach($packaging as $d)
                            <option @if($d->id == $matout->labelling_id) selected @endif value="{{$d->id}}" >{{$d->packaging_name}}</option>
                        @endforeach
                    @else
                        @foreach($packaging as $d)
                            <option value="{{$d->id}}" >{{$d->packaging_name}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
                @error('labelling_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          @endif

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Quantity<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('quantity') is-invalid @enderror" value="{{ old('quantity', $matout->quantity ?? '') }}" type="number" name="quantity" required='required'>
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
              <textarea name='keterangan' rows="3" class="form-control" name="keterangan"autocomplete="keterangan">{{ old('keterangan', $matout->keterangan ?? '') }}</textarea>
            </div>
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
          <button type='submit' class="btn btn-primary">Submit</button>
          @if(isset($matout))
            @if(isset($sts))
                <a href="{{ route('pengeluaran_labelling2.index2') }}" class="btn btn-danger">Cancel</a>
              @else
                <a href="{{ route('pengeluaran_labelling.index') }}" class="btn btn-danger">Cancel</a>
              @endif
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