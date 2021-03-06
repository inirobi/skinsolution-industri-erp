@extends('layouts.master')
@section('site-title')
  Products
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Update Product</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('produksi.index')}}">Products</a></li>
            <li><a>Update Product</a></li>
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
        @foreach($product as $data)
        <form action="{{route('produksi.update',$data->xx)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
          <p>Wajib disi <code>*</code>
          </p>
          <span class="section"> Update Product </span>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Product Code<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', $data->product_code ?? '') }}" name="product_code" required="required" />
            </div>
            @error('product_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Product Name<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', $data->product_name ?? '') }}" name="product_name" required="required" />
            </div>
            @error('product_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Customer<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="customer_id">
                @foreach($customer as $d)
                    <option @if($d->id == $data->customer_id) selected @endif value="{{$d->id}}" >{{$d->customer_name}}</option>
                @endforeach
              </select>
            </div>
            @error('customer_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Formula<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control" name="formula_id">
                  @foreach($formula as $d)
                      <option @if($d->id == $data->formula_id) selected @endif value="{{$d->id}}" >{{$d->formula_num}}</option>
                  @endforeach
              </select>
            </div>
            @error('formula_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
         
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Revision Numbe<code>*</code></label>
            <div class="col-md-6 col-sm-6">
            <select class="form-control" name="trial_revision_data_id">
                @foreach($revision as $d)
                    <option @if($d->id == $data->trial_revision_data_id) selected @endif value="{{$d->id}}" >{{$d->revision_num}}</option>
                @endforeach
            </select>
            </div>
            @error('trial_revision_data_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Description<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <textarea class="form-control" name="description" rows="3">{{ old('description', $data->description ?? '') }}</textarea>
            </div>
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Sale Price<code>*</code></label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $data->sale_price ?? '') }}" name="sale_price" required="required" />
            </div>
            @error('sale_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Packaging<code>*</code></label>
            <div class="col-md-6 col-sm-6">
                <select class="form-control" name="packaging_id">
                    <option value="0">--Select Packaging--</option>
                    @foreach($packaging as $bv)        
                        @if($bv->category!="sticker" && $bv->category!="Stiker" && $bv->category!="Sticker" && $bv->category!="box" && $bv->category!="Box")
                        <option value="{{$bv->id}}"  @if($data->id_packaging == $bv->id) selected @endif >{{$bv->category}} - {{$bv->packaging_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @error('packaging_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Labelling<code>*</code></label>
            <div class="col-md-6 col-sm-6">
                <select class="form-control" name="labelling_id">
                    <option value="0">--Select Labelling--</option>
                    @foreach($packaging as $vb)
                        @if( ($vb->category=="sticker" || $vb->category=="Stiker" || $vb->category=="Sticker" || $vb->category=="box" || $vb->category=="Box") )
                        <option value="{{$vb->id}}" @if($data->id_labelling == $vb->id) selected @endif> {{$vb->category}} - {{$vb->packaging_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            @error('labelling_id')
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
        @endforeach
      </div>
    </div>
  </div>
</div>
<!-- /page content -->


@push('scripts')
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush

@endsection