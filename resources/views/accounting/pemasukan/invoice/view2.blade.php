@extends('layouts.master')
@section('site-title')
  Invoice
@endsection
@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Invoice List View</h3>
  </div>

  <div class="title_right">
    <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div style='float:right'>
      <div class="input-group">
        <ul class="breadcrumb">
          <li><a href="{{url('/home')}}">Home</a></li>
          <li><a href="{{route('invoice.index')}}">Invoice List</a></li>
          <li>Invoice List View</li>
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
      <div class="x_title">
          <h2>Input Invoice</h2>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
        <form novalidate method="POST" enctype="multipart/form-data" action="{{route('invoice.update', $invs->id)}}">
          @method('PUT')
          {{csrf_field()}}
          <input type="hidden" class="form-control"  value= '{{$invs->po_customer_id}}' name="po_product_id">
          <div class="field item form-group">
            <label for="kode" class="col-form-label col-md-3 col-sm-3 label-align">Jenis Invoice<code>*</code> :</label>
            <div class="col-md-3 col-sm-3">
              <input class="form-control" type="text" readonly value="Other" required="required" /> 
              <input type="hidden" name="jenis_invoice" value="other">
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Shipped via<code>*</code> : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value='{{$invs->shipped}}' name="shipped"/>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">No Invoice<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value='{{$invs->invoice_num}}' readonly name="invoice_num"/>
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Customer<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value='{{$invs->customer_name}}' readonly name="customer_id" />
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value= '{{$invs->po_num}}' readonly name="po_product_id" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">FOB Point<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value='{{$invs->fob}}' name="fob" />
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Terms<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input class="form-control" value= '{{$invs->terms}}' readonly name="term"/>
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Status<code>*</code></label>
                <div class="col-md-6 col-sm-6">
                  <input type="hidden" name="money" value="{{$total}}">
                  <select class="form-control" name="status">
                    <option  @if($invs->status=='Paid') selected @endif value="Paid" >Paid</option>
                    <option @if($invs->status=='Unpaid') selected @endif value="Unpaid">Unpaid</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <a href="{{route('invoice.index')}}" class="btn btn-danger pull-right"> Cancel </a>
            <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-floppy-o"></i> Save </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@if(!empty($invs))
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Invoice</h2>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
        <form class="form-horizontal" role="form" method="post">
        {{csrf_field()}}
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">No Invoice : </label>
                <div class="col-md-6 col-sm-6">
                  <label class="col-form-label">{{$invs->invoice_num}}</label>
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">No PO : </label>
                <div class="col-md-6 col-sm-6">
                  <label class="col-form-label">{{$invs->po_num}}</label>
                </div>
              </div>
              <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">PO Date : </label>
                <div class="col-md-6 col-sm-6">
                  <label class="col-form-label">1{{$invs->date}}</label>
                </div>
              </div>
            </div>
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">To : </label>
                  <div class="col-md-6 col-sm-6">
                    <label class="col-form-label">{{$invs->customer_name}}</label>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-12">
            <a data-toggle="modal" href="#modalAdd" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Item</a>
          </div>
          <div class="col-md-12">
           <table class="table table-striped">
              <thead>
                <tr >
                  <th>DESCRIPTION</th>										
                  <th>PRICE</th>
                </tr>
              </thead>
              <tbody>
                @php $total=0; $total1=0; @endphp
                @if(!empty($invo))
                  @foreach($invo as $dt)
                    @if($dt->jenis=="other")
                      <tr id="row1">
                        <td>  {{$dt->description}}</td>
                        <td>Rp {{number_format($dt->price,2)}}  </td>
                        @php $total1+=($dt->price); @endphp
                      </tr>
                    @endif
                  @endforeach
                  <tr id="row1">
                    <td><strong>Total</strong></td>
                    <td><strong> Rp {{number_format($total1,2)}} </strong></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
          <a class="btn btn-primary" onclick="javascript:window.print()" href="#" title="Print" class="btn btn-small text-primary"><i class="fa fa-print"></i> Print</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endif


<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add New Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('invoice.detailstore2')}}" role="form" method="post">
          {{csrf_field()}}
          <input type='hidden' class="form-control" value="{{$invs->id}}" name="invoice_id" />
          
          <div class="form-group">
            <label class="control-label col-md-2">Description</label>
            <textarea name="description" class='form-control' required></textarea>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Price</label>
            <input name='price' type='number' class='form-control' required>
          </div>

            <br>
          <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
@endsection

@push('print')
<div class="page-title">
  <div class="title_left">
    <h3>INVOICE</h3>
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
<div class="col-md-12">
  <div class="col-md-6">
    <div class="field item form-group">
      <label class="col-form-label col-md-3 col-sm-3  label-align">No Invoice : </label>
      <div class="col-md-6 col-sm-6">
        <label class="col-form-label">{{$invs->invoice_num}}</label>
      </div>
    </div>
    <div class="field item form-group">
      <label class="col-form-label col-md-3 col-sm-3  label-align">No PO : </label>
      <div class="col-md-6 col-sm-6">
        <label class="col-form-label">{{$invs->po_num}}</label>
      </div>
    </div>
  </div>
    <div class="col-md-6 pull-right">
      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">To : </label>
        <div class="col-md-6 col-sm-6">
          <label class="col-form-label">{{$invs->customer_name}}</label>
        </div>
      </div>
      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">PO Date : </label>
        <div class="col-md-6 col-sm-6">
          <label class="col-form-label">1{{$invs->date}}</label>
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
							<th>DESCRIPTION</th>										
              <th>PRICE</th>
						</tr>
					</thead>
					<tbody>
            @php 
              $total=0;
              $total1=0;
              $no = 1; 
            @endphp
            @if(!empty($invo))
              @foreach($invo as $dt)
                @if($dt->jenis=="other")
                  <tr id="row1">
                    <td>{{$no++}}</td>
                    <td>  {{$dt->description}}</td>
                    <td>Rp {{number_format($dt->price,2)}}  </td>
                    @php $total1+=($dt->price); @endphp
                  </tr>
                @endif
              @endforeach
              <tr id="row1">
                <td colspan='2' style="text-align:center"><strong>Total : </strong></td>
                <td><strong> Rp {{number_format($total1,2)}} </strong></td>
              </tr>
            @endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endpush