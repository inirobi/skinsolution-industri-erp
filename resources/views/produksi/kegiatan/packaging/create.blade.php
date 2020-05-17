@extends('layouts.master')
@section('site-title')
  Filling
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Add New Filling</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('activity_packaging.index')}}">Filling</a></li>
            <li><a>Add Filling</a></li>
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
        <form action="{{ route('activity_packaging.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section">
            {{ __('Form Filling') }}
          </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Activity Code<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('activity_code') is-invalid @enderror" name="activity_code" required="required" />
            </div>
            @error('activity_code')
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
                          <input autocomplete='off' type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date" aria-describedby="date" name="date">
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
              <label class="col-form-label col-md-3 col-sm-3  label-align">Production Code <code>*</code></label>
              <div class="col-md-6 col-sm-6">
                  <select class="form-control @error('product_activity_id') is-invalid @enderror" name="product_activity_id" id="product_activity_id">
                      @foreach($poprd as $d)
                        @if($d->status=="Release")
                          <option value="{{$d->id}}" >{{$d->activity_code}}</option>
                          @endif
                      @endforeach
                  </select>
              </div>
              @error('product_activity_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

          <div class="field item form-group">
              <label class="col-form-label col-md-3 col-sm-3  label-align">Product Code <code>*</code></label>
              <div class="col-md-6 col-sm-6">
                  <select class="form-control @error('product_id') is-invalid @enderror" id="product_code_detail" name="product_id">
                    <option disabled selected value> -- Select Production Code -- </option>
                  </select>
              </div>
              @error('product_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Production Result<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input id="production_result" class="form-control number @error('production_result') is-invalid @enderror" type="number" name="production_result" required='required'>
            </div>
            @error('production_result')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging Result<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('packaging_result') is-invalid @enderror" type="number" name="packaging_result" required='required'>
            </div>
            @error('packaging_result')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Used Quantity<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('used_quantity') is-invalid @enderror" type="number" name="used_quantity" required='required'>
            </div>
            @error('used_quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

            <label class="col-form-label col-md-3 col-sm-3  label-align">Ruahan<code>*</code></label>
          <div class="field item form-group">
            <div class="col-md-6 col-sm-6">
              <input class="form-control number @error('ruahan') is-invalid @enderror" type="number" name="ruahan" required='required'>
            </div>
            @error('ruahan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Description <code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea required="required" name='description' rows="3" class="form-control  @error('description') is-invalid @enderror" name="description" required autocomplete="description"></textarea>
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
    $('#product_activity_id').on('change', function(e){
        var product_activity_id = e.target.value;
        $.get('{{ url('') }}/packaging_activity/addprdcode/ajax-state/' + product_activity_id, function(data) {
            $('#product_code_detail').empty();
            $.each(data, function(index, subcatObj){
                $('#product_code_detail').append('<option value="'+subcatObj.id+'">'+subcatObj.product_name+'</option>')
            });
        });

        $.get('{{ url('') }}/packaging_activity/add/ajax-state/' + product_activity_id, function(data) {
            $('#production_result').attr('value',data[0].result_real);
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