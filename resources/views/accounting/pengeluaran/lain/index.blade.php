@extends('layouts.master')
@section('site-title')
  Purchase Order Other
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Other Lists</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li>Purchase Order Other</li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
      <a href="{{ route('pengeluaran_lain.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New PO Others </a>
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
                    <th>PO Number</th>
                    <th>Supplier Name</th>
                    <th>Date</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Total Pay</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1 @endphp
                  @foreach($lain as $data)
                  @php
                    $poPackagingdetail =  App\PoLainDetail::where('polain_id', $data->id)->get(); 
                    $total = 0;
                    $PPN = 0;
                    foreach ($poPackagingdetail as $dataDetail) {
                        $total = $total + ($dataDetail->quantity * $dataDetail->harga);
                    }

                    $PPN = 0.10 * $total;
                    $totalWithPPN = $total + $PPN;
                  @endphp

                    <tr>
                      <td>{{$no++}}</td>
                      <td> {{$data->po_num}} </td>
                      <td> {{$data->supplier->supplier_name}}</td>
                      <td> {{$data->date}}</td>
                      <td> 
                          @if($data->ppn==0) 0 @endif
                          @if($data->ppn==1) 10% @endif
                      </td>
                      <td> {{number_format($total,2)}}</td>
                      <td> 
                          @if($data->ppn==0) {{number_format($total,2)}} @endif
                          @if($data->ppn==1) {{number_format($totalWithPPN,2)}} @endif
                      </td>
                      @if(isset($notif->id_lain))
                      @foreach($notif as $dt) 
                      
                          @if($data->id==$dt->id_lain)
                            <td class="badge badge-notify bg-danger"> {{$data->status}}</td>
                          @else
                                <td> {{$data->status}}</td>
                          @endif
                          @endforeach
                      @else
                      <td> 
                        @if($data->status == 'Unpaid')<span class="badge badge-danger">{{$data->status}}</span>@endif
                        @if($data->status == 'Paid')<span class="badge bg-green">{{$data->status}}</span>@endif
                      </td>
                      @endif
                         <td>
                            <a class="btn btn-info" href="{{ route('pengeluaran_lain.show',$data->id) }}" title="Detail" class="btn btn-small text-primary">
                              <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('pengeluaran_lain.edit',$data->id) }}" class="btn btn-warning" title="Edit">
                              <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('pengeluaran_lain.destroy', $data->id) }}" class="btn btn-danger" onclick="event.preventDefault();destroy('{{ route('pengeluaran_lain.destroy', $data->id) }}')" title="Hapus"><i class="fa fa-trash"></i></a>
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
<!-- /page content -->
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
</script>
@endpush
@endsection