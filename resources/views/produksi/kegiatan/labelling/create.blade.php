@extends('layouts.master')
@section('site-title')
  Labelling
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Add New Labelling</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('labelling.index')}}">Labelling</a></li>
            <li><a>Add Labelling</a></li>
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
          <form action="{{ route('labelling.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
                {{ __('Form Labelling') }}
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Labelling Code<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('labelling_code') is-invalid @enderror" value="{{ old('labelling_code', $labellings->labelling_code ?? '') }}" name="labelling_code" required="required" />
            </div>
            @error('labelling_code')
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
                          <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" value="{{ old('date', $lain->date ?? '') }}" name="date">
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
              <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Activity <code>*</code></label>
              <div class="col-md-6 col-sm-6">
                  <select class="form-control @error('packaging_activity_id') is-invalid @enderror" id="packaging_activity_id" name="packaging_activity_id">
                      @foreach($pckg as $d)
                          <option value="{{$d->id}}" >{{$d->activity_code}}</option>
                      @endforeach
                  </select>
              </div>
              @error('packaging_activity_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Result<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('packaging_result') is-invalid @enderror" id="packaging_result" value="{{ old('packaging_result', $labellings->packaging_result ?? '') }}" type="number" name="packaging_result" required='required'>
            </div>
            @error('packaging_result')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Labelling Result<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control  @error('result') is-invalid @enderror" value="{{ old('result', $labellings->result ?? '') }}" type="number" name="result" required='required' />
            </div>
            @error('result')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Quantity<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input id="packaging_quantity" class="form-control"  disabled type="number" />
            </div>
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Stock<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control " type="number" id="packaging_stock" disabled>
            </div>
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Used Quantity<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('used_quantity') is-invalid @enderror" value="{{ old('used_quantity', $labellings->used_quantity ?? '') }}" type="number" name="used_quantity" required='required'>
            </div>
            @error('used_quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Description <code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='description' rows="3" class="form-control  @error('description') is-invalid @enderror" name="description" required autocomplete="description">{{ old('description', $labellings->description ?? '') }}</textarea>
            </div>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="ln_solid">
            <div class="form-group">
              <div class="col-md-6 offset-md-3">
                <button type='submit' class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-success">Reset</button>
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
<script>
    $('#packaging_activity_id').on('change', function(e){
        var packaging_activity_id = e.target.value;
        $.get('{{ url('') }}/labelling/add/ajax-state/' + packaging_activity_id, function(data) {
            $('#packaging_result').attr('value',data[0].packaging_result);
            $('#packaging_quantity').attr('value',data[0].quantity);
            $('#packaging_stock').attr('value',data[0].packaging_quantity);
        });
    });
</script>  
    <!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>


@endpush
@endsection