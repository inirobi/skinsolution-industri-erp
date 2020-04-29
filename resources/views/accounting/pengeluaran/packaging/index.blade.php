@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Purchase Order Packaging List</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-secondary" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Purchase Order Packaging</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              
              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                  @foreach($purchase as $data)
                    @php
                      $poPackagingdetail =  App\PoPackagingDetail::where('po_packaging_id', $data->id)->get(); 
                      $total = 0;
                      $PPN = 0;
                      foreach ($poPackagingdetail as $dataDetail) {
                          $total = $total + ($dataDetail->quantity * $dataDetail->price);
                      }                                   
                      $PPN = 0.10 * $total;
                      $totalWithPPN = $total + $PPN;
                    @endphp

                    <tr>
                        <td>{{$no++}}</td>
                        <td> {{$data->po_num}} </td>
                        <td> {{$data->supplier->supplier_name}}</td>
                        <td> {{$data->po_date}}</td>
                        <td> 
                            @if($data->ppn==0) 0 @endif
                            @if($data->ppn==1) 10% @endif
                        </td>
                        <td> {{number_format($total,2)}}</td>
                        <td> 
                            @if($data->ppn==0) {{number_format($total,2)}} @endif
                            @if($data->ppn==1) {{number_format($totalWithPPN,2)}} @endif
                        </td>
                        @if(!empty($noti->id_packaging))
                        @foreach($notif as $dt) 
                            @if($data->id==$dt->id_packaging)
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
                            <a class="btn btn-info" href="{{url('accounting_POpackaging/view',$data->id)}}" title="Detail" class="btn btn-small text-primary">
                              <i class="fa fa-eye"></i>
                            </a>
                          <a href="#" class="btn btn-warning" title="Edit" onclick="changeStatus('{{ $data -> id }}')">
                              <i class="fa fa-edit"></i>
                            </a>
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

<div class="modal fade bs-example-modal-sm" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Change Paid Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ url('accounting_POpackaging')}}" method="post">
          @method('PUT')
          @csrf
          <input type="hidden" name="kode" id="kode">
          <div class="form-group">
            <label for="kode" class="col-form-label">Status : </label>
            <select class="form-control" name="status" id="status">
              <option value="Paid">Paid</option>
              <option value="Unpaid">Unpaid</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save"></i> Save
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- script section -->
<script type="text/javascript">
  function changeStatus(kode)
{
    $('#kode').attr('value',kode);
    $('#modalEdit').modal();
}
</script>
</script>
@endsection