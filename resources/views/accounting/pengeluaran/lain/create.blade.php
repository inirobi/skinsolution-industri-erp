@extends('layouts.master')
@section('site-title')
  Purchase Order Other
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush
@section('content')
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3>Purchase Order Other List</h3>
    </div>
    <div class="title_right">
        <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div style='float:right'>
                <div class="input-group">
                    <ul class="breadcrumb">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{route('pengeluaran_lain.index')}}"> Purchase Order Other</a></li>
                        @if(isset($lain))
                            <li><a>Update Purchase Order Other</a></li>
                        @else
                            <li><a>Add Purchase Order Other</a></li>
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
                @if(isset($lain))
                    <form action="{{ route('pengeluaran_lain.update', $lain) }}" novalidate method="POST" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form action="{{ route('pengeluaran_lain.store') }}" method="POST" enctype="multipart/form-data">
                @endif

                        @csrf
                        <p>Wajib disi <code>*</code>
                        </p>
                        <span class="section">
                            @if(isset($lain))
                            {{ __('Update Purchase Order Other List') }}
                            @else
                            {{ __('Form Purchase Order Other List') }}
                            @endif
                        </span>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control @error('po_num') is-invalid @enderror"
                                    value="{{ old('po_num', $lain->po_num ?? '') }}"
                                    name="po_num" required="required" autofocus placeholder="Packaging Code"/>
                            </div>
                            @error('po_num')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Supllier <code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id">
                                @if(isset($lain))
                                    @foreach($supplier as $d)
                                        <option @php if($d->id==$lain->supplier_id) echo'selected';@endphp value="{{$d->id}}" >{{$d->supplier_name}}</option>
                                    @endforeach
                                @else
                                    @foreach($supplier as $d)
                                        <option value="{{$d->id}}" >{{$d->supplier_name}}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                            @error('supplier_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Terms <code>*</code></label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control @error('terms') is-invalid @enderror" name="terms">
                                    <option value="Cash" >Cash</option>
                                    <option value="7 Days" >7 Days</option>
                                    <option value="14 Days" >14 Days</option>
                                    <option value="30 Days" >30 Days</option>
                                </select>
                            </div>
                            @error('terms')
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
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">PPN <code>*</code></label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="ppn" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-customer">
                                        <input type="radio" value="1" id="ppn" name="ppn" checked='checked' class="join-btn">
                                        &nbsp; Yes
                                    </label>
                                    <label class="btn btn-secondary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-supplier">
                                        <input type="radio" value="0" id="ppn" name="ppn"
                                            class="join-btn">
                                        &nbsp; No
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if(isset($lain))
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Status <code>*</code></label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="status" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-paid">
                                        <input type="radio" value="Paid" id="status" name="status"
                                        checked='checked' class="join-btn">
                                        &nbsp; Paid
                                    </label>
                                    <label class="btn btn-secondary" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default" id="btn-unpaid">
                                        <input type="radio" value="Unpaid" id="status" name="status"
                                            class="join-btn">
                                        &nbsp; Unpaid
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" onclick="javascript:history.back()">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@include('layouts.validasi_footer')

@push('scripts')
<script>
    $.get('{{url("packagings/customer/ajax")}}', function (data) {
        $('#vendor').empty();
        $.each(data, function (index, subcatObj) {
            $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj.customer_name +
                '</option>')
        });
    });


    $('input[type=radio][name=ppn]').change(function () {
        var source = this.value;

        if (source == "0") {
            $('#btn-customer').attr('class', 'btn btn-secondary');
            $('#btn-supplier').attr('class', 'btn btn-primary');
            $.get('{{url("packagings/supplier/ajax")}}', function (data) {
                $('#vendor').empty();
                $.each(data, function (index, subcatObj) {
                    $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj
                        .supplier_name + '</option>')
                });
            });


        }
        if (source == "1") {
            $('#btn-customer').attr('class', 'btn btn-primary');
            $('#btn-supplier').attr('class', 'btn btn-secondary');
            $.get('{{url("packagings/customer/ajax")}}', function (data) {
                $('#vendor').empty();
                $.each(data, function (index, subcatObj) {
                    $('#vendor').append('<option value="' + subcatObj.id + '">' + subcatObj
                        .customer_name + '</option>')
                });
            });
        }




    });

    $('input[type=radio][name=status]').change(function () {
        var source = this.value;
        if (source == "Paid") {
            $('#btn-unpaid').attr('class', 'btn btn-secondary');
            $('#btn-paid').attr('class', 'btn btn-primary');
        }
        if (source == "Unpaid") {
            $('#btn-paid').attr('class', 'btn btn-secondary');
            $('#btn-unpaid').attr('class', 'btn btn-primary');
        }




    });

</script>
    <!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-datetimepicker -->    
<script src="{{ asset('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
@endsection
