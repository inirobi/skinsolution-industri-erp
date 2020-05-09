@extends('layouts.master')
@section('site-title')
  Formula
@endsection
@push('styles')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="
    {{ asset('assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Formula View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div style='float:right'>
        <div class="input-group">
          <ul class="breadcrumb">
            <li><a href="{{url('/home')}}">Home</a></li>
            <li><a href="{{route('formula.index')}}">Formulas</a></li>
            <li><a>Formula View</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Formula View</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form action="#" novalidate method="POST" enctype="multipart/form-data">
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Formula Number : </label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value="{{$formula->formula_num}}" disabled />
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Date : </label>
                <div class="col-md-6 col-sm-6 xdisplay_inputx form-group has-feedback">
                  <input value="{{$formula->created_at}}" type="text" class="form-control has-feedback-left" disabled placeholder="Date">
                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
      <a data-toggle="modal" href="#modalAdd" class="btn btn-success" ><i class="fa fa-plus"></i>Add New Material </a>
      <button class="pull-right btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Material</th>
                    <th>Source Material</th>
                    <th>Quantity Material (%)</th>
                    <th>Weighing</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1;
                  @endphp
                  @foreach($formula_view as $data)
                    <tr>
                      <td>{{$no++}}</td>
                      <td> 
                          @if (!$data->source_material) {{$data->sampleMaterial->material_name}} @endif
                          @if ($data->source_material) {{$data->material->material_name}} @endif                                                     
                      </td>
                      <td>
                          @if (!$data->source_material) From Sample @endif
                          @if ($data->source_material) From Material @endif
                      </td>
                      <td> {{$data->quantity}}</td>
                      <td> {{$data->weighing}}</td>
                      <td> {{$data->created_at}}</td>
                      <td>
                        <a href="{{route('formula.destroy.view',$data->id)}}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{route('formula.destroy.view',$data->id)}}');" title="Hapus"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('formula.store.view') }}" role="form" method="post">
          {{csrf_field()}}
          <input type="hidden" name="formula_id" value="{{$formula->id}}" >
          <div class="form-group">
            <label class="control-label">Source Material</label>
            <select class="form-control" id="source_material" name="source_material">
                <option disabled selected value> -- Select Source -- </option>
                <option value="0" >From Sample</option>
                <option value="1" >From Material</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Material Name</label>
            <select class="form-control" id="material" name="material_id"></select>
          </div>

          <div class="form-group">
            <label class="control-label">Quantity</label>
            <input type="text" class="form-control" placeholder="Quantity" required name="quantity">
          </div>
          
          <div class="form-group">
            <label class="control-label">Weighing</label>
            <input type="text" class="form-control" placeholder="Weighing" required name="weighing">
          </div>
          
            <div class="modal-footer">
              <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>

@push('scripts')
<script>
function destroy(action){
  swal({
      title: 'Apakah anda yakin?',
      text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
      icon: 'warning',
      buttons: ["Cancel", "Yes!"],
  }).then(function(value) {
      if (value) {
        document.getElementById('destroy-form').setAttribute('action', action);
        document.getElementById('destroy-form').submit();
      }else {
      swal("Data kamu aman!");
    }
  });
}
$('#source_material').on('change', function(e){
  var source = e.target.value;
  $.get('{{ url('') }}/formula/view/add/ajax-state/' + source, function(data) {
    $('#material').empty();
      $.each(data, function(index, subcatObj){
          $('#material').append('<option value="'+subcatObj.id+'">'+subcatObj.material_name+'</option>')
      });
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

@push('print')
<div class="page-title">
  <div class="title_left">
    <h3>Formula</h3>
  </div>
  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div style='float:right;text-align:right'>
			<img src="{{asset('assets/src/img/logo-skin-care.png')}}" />
			<br><br>
			<h2 style="font-size:14pt">CV SKIN SOLUTION BEAUTY CARE INDONESIA <br>
				<small>
					Jalan Waruga Jaya No. 47, Ciwaruga <br>
					Parongpong, 40559 <br>
					West Java, Indonesia <br>
					Phone:(022) 820-270-55 <br>
				</small>
			</h2>
		</div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

	<div class="row" style="display: block;">
		<div class="col-md-12  ">
			<div class="x_content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>NO</th>
							<th>MATERIAL</th>
							<th>SOURCE MATERIAL</th>
							<th>QUANTITY MATERIAL</th>
						</tr>
					</thead>
					<tbody>
            @php $nomor = 1; @endphp 
            @foreach($formula_view as $data)
              <tr id="row1">
                <td>{{$nomor++}}</td>
                <td> 
                  @if (!$data->source_material) {{$data->sampleMaterial->material_name}} @endif
                  @if ($data->source_material) {{$data->material->material_name}} @endif                                                     
                </td>
                <td>
                  @if (!$data->source_material) From Sample @endif
                  @if ($data->source_material) From Material @endif
                </td>
                <td> {{$data->quantity}}</td>
                
              </tr>
            @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endpush
@push('styles')
<style>
#printable { display: none; }

@media print
{
    #non-printable { display: none; }
    #printable { display: block; }
}
</style>
@endpush