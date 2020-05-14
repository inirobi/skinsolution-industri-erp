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
          <form novalidate method="POST" action="{{route('invoice.update', $inv->id)}}" enctype="multipart/form-data">
          @method('PUT')
          {{csrf_field()}}
          <input type="hidden" class="form-control"  value= '{{$inv->po_product_id}}' name="po_product_id">
          <div class="field item form-group">
            <label for="kode" class="col-form-label col-md-3 col-sm-3 label-align">Jenis Invoice<code>*</code> :</label>
            <div class="col-md-3 col-sm-3">
              <select class="form-control" name="jenis_invoice" id="jenis_invoice">
                <option value="dp" >Dp</option>
                <option value="nondp" >Non Dp</option>
                <option value="other" >Other</option>
              </select>
            </div>
          </div>
          <div class="field item form-group" id="jenis">
            <label for="kode" class="col-form-label col-md-3 col-sm-3 label-align" >Jenis DP<code>*</code> :</label>
            <div class="col-md-3 col-sm-3">
              <select class="form-control" name="jenis_dp" id="jenis_dp">
                <option value="persen" id="x">Persen</option>
                <option value="rupiah" id="y">Rupiah</option>
              </select>
            </div>
          </div>

          <div class="field item form-group" id="persen">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jumlah Persen<code>*</code> : </label>
            <div class="col-md-3 col-sm-3">
              <input class="form-control" id='dp' type='number' name="dpPersen" required="required" /> 
            </div>%
          </div>

          <div class="field item form-group" id="rupiah">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Jumlah Rupiah<code>*</code> : </label>
            <div class="col-md-3 col-sm-3">
              <input class="form-control" id='dp' type='number' name="dpRupiah" required="required" /> 
            </div>
          </div>
          <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Shipped via : </label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control" value='{{$inv->shipped}}' name="shipped"/>
            </div>
          </div>
          <div class="col-md12">
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">No Invoice<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input readonly class="form-control" value='{{$inv->invoice_num}}' required name="invoice_num" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Customer<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" readonly value='{{$inv->customer->customer_name}}' required name="customer_id" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">PO Number<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" readonly value= '{{$inv->po_product->po_num}}' required name="po_product_id" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">FOB Point<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" value='{{$inv->fob}}' class="form-control" name="fob" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Terms<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" value= '{{$inv->terms}}' readonly name="term" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Status<code>*</code></label>
                  <div class="col-md-6 col-sm-6">
                    <select class="form-control" name="status">
                        <option  @if($inv->status=='Paid') selected @endif value="Paid" >Paid</option>
                        <option @if($inv->status=='Unpaid') selected @endif value="Unpaid">Unpaid</option>    
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
@if(!empty($inv))
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Input Invoice</h2>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
        <form class="form-horizontal" role="form" method="post" action="">
        {{csrf_field()}}
          <div class="col-md12">
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">No Invoice : </label>
                  <div class="col-md-6 col-sm-6">
                    <label class="col-form-label">{{$inv->invoice_num}}</label>
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">No PO : </label>
                  <div class="col-md-6 col-sm-6">
                    <label class="col-form-label">{{$inv->po_product->po_num}}</label>
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">PO Date : </label>
                  <div class="col-md-6 col-sm-6">
                    <label class="col-form-label">{{$inv->po_product->date}}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">To : </label>
                  <div class="col-md-6 col-sm-6">
                    <label class="col-form-label">{{$inv->customer->customer_name}}</label>
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
                  <th>QUANTITY</th>														
                  <th>PRICE</th>
                  <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($podetail->first()))
                  @php $total=0; $total1=0;$tamp=0;$tamp2=0; @endphp
                    @foreach($podetail as $d)
                      <tr id="row1">
                        <input type="hidden" class="form-control" value='{{$d->id}}' required name="id[]">
                        <input type="hidden" class="form-control" value='{{$inv->id}}' required name="invoice_id[]">
                        <input type="hidden" class="form-control" value='{{$inv->po_product_id}}' required name="po_product_id[]">
                        <td>  {{$d->product->product_name}}</td>
                        <td> {{$d->quantity}}</td>
                        <td>Rp {{number_format($d->product->sale_price,2)}}  </td>
                        <td>Rp {{number_format($d->quantity * $d->product->sale_price,2)}} </td>
                      @php $total1+=($d->quantity * $d->product->sale_price); @endphp
                      </tr>                                            
                      @if(!empty($pack))
                        @foreach($pack as $dt1)
                          <tr id="row1">
                            <td>  {{$dt1->category}} - {{$dt1->packaging_name}}  </td>
                            <td>{{$dt1->quantity}}</td>
                            <td>Rp {{number_format($dt1->price,2)}}  </td>
                            <td>Rp {{number_format($dt1->quantity * $dt1->price,2)}} </td>
                            @php $total1+=($dt1->quantity * $dt1->price); @endphp
                          </tr>                   
                        @endforeach
                      @endif
                      
                      @if(!empty($lab))
                        @foreach($lab as $dt2)
                          <tr id="row1">
                            <td>  {{$dt2->category}} - {{$dt2->packaging_name}}  </td>
                            <td>Rp {{$dt2->quantity}}</td>
                            <td>Rp {{number_format($dt2->price,2)}}  </td>
                            <td>Rp {{number_format($dt2->quantity * $dt2->price,2)}} </td>
                              @php $total1+=($dt2->quantity * $dt2->price); @endphp
                          </tr>
                        @endforeach
                      @endif
                    @endforeach
                    @if(!empty($invo))
                      @foreach($invo as $dt)
                        @if($dt->jenis=="ya")  
                          <tr id="row1">
                            <td>  {{$dt->description}}  </td>
                            <!--<td>   @if($inv->jenis_invoice=='nondp')  <input type="text" class="form-control" value='{{$dt->quantity}}' required name="quantity[]"> @else {{$dt->quantity}} @endif</td>-->
                            <td>{{$dt->quantity}}</td>
                            <td>Rp {{number_format($dt->price,2)}}  </td>
                            <td>Rp {{number_format($dt->quantity * $dt->price,2)}} </td>
                            @php $total1+=($dt->quantity * $dt->price); @endphp
                          </tr>
                        @endif
                      @endforeach
                    @endif
                    <tr id="row1">
                      <td colspan="3"><strong>Sub Total</strong></td>
                      <td><strong> Rp {{number_format($total1,2)}} </strong></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong>Down Payment</strong></td>
                      @if(($inv->jenis_invoice=='dp' || $inv->jenis_invoice=='nondp') && $inv->jenis_dp=='persen')
                        <td><strong> {{$inv->dp}} % </strong></td>
                        <td><strong> ( Rp {{number_format(($total1 * $inv->dp)/100,2)}} ) </strong></td>
                          
                      @elseif(($inv->jenis_invoice=='dp' || $inv->jenis_invoice=='nondp') && $inv->jenis_dp=='rupiah')
                        <td><strong> </strong></td>
                        <td><strong> ( Rp {{number_format(( $inv->dp),2)}} ) </strong></td>
                          
                      @else($inv->jenis_invoice=='other')
                        <td><strong> </strong></td>
                        <td><strong> ( Rp {{number_format(( $inv->dp),2)}} ) </strong></td>
                      @endif
                    </tr>
                    @if(!empty($invo))
                      @foreach($invo as $dt)
                        @if($dt->jenis=="tidak")
                          <tr id="row1">
                            <td>{{$dt->description}}  </td>
                            <td>{{$dt->quantity}}</td>
                            <td>Rp {{number_format($dt->price,2)}}  </td>
                            <td>Rp {{number_format($dt->quantity * $dt->price,2)}} </td>
                            @php $tamp+=($dt->quantity * $dt->price); @endphp
                          </tr>
                        @endif
                      @endforeach
                    @endif
                    @if($inv->jenis_invoice=='nondp')
                      <tr id="row1">
                        @if($inv->jenis_dp=='rupiah')
                          <td colspan="3"><strong>Total</strong></td>
                          <td><strong>Rp {{number_format($total+$total1-($inv->dp) + $tamp,2)}} </strong></td>
                        @else($inv->jenis_dp=='persen')
                          <td colspan="3"><strong>Total</strong></td>
                          <td><strong>Rp {{number_format($total+$total1-(($total1 * $inv->dp)/100) + $tamp,2)}} </strong></td>
                        @endif
                      </tr>
                    @else($inv->jenis_invoice=='dp')
                      <tr id="row1">
                        @if($inv->jenis_dp=='rupiah')
                          <td colspan="3"><strong>Total</strong></td>
                          <td><strong> ( Rp {{number_format(($inv->dp + $tamp),2)}} ) </strong></td>
                        @else($inv->jenis_dp=='persen')
                          <td colspan="3"><strong>Total</strong></td>
                          <td><strong> ( Rp {{number_format(($inv->dp/100 * $total1) + ($tamp),2)}} ) </strong></td>
                        @endif  
                      </tr>
                    @endif
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
        <form action="{{ route('invoice.detailstore') }}" role="form" method="post">
          {{csrf_field()}}
          <input type='hidden' class="form-control" value="{{$inv->id}}" name="invoice_id" />
          
          <div class="form-group">
            <label class="control-label col-md-2">Description</label>
            <textarea name="description" class='form-control' required></textarea>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Quantity</label>
            <input name='quantity' type='number' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Price</label>
            <input name='price' type='number' class='form-control' required>
          </div>

          <div class="form-group">
            <label class="control-label col-md-2">Dikurangi DP</label>
            <select class="form-control" name="kurang_dp">
                <option value="ya" >Ya</option>
                <option value="tidak" >Tidak</option>
            </select>
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

@endsection

@push('styles')
   <!-- iCheck -->
   <link href="{{ asset('assets/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script>
$("#rupiah").hide();
  $('#jenis_invoice').change(function() { 
  var source = this.value;
    console.log("hai");
    console.log(source);
      if(source=="dp"){
          $("#persen").show();
          $("#rupiah").hide();
          $("#jenis").show();        
      }
      else if(source=="nondp"){
          $("#persen").show();
          $("#rupiah").hide();
          $("#jenis").show();              
      }
      else if(source=="other"){
          $("#persen").hide();
          $("#rupiah").hide();
          $("#jenis").hide();

      }
      $('#jenis_dp').change(function() {
          var x = this.value;
          if(x=="persen"){
              $("#persen").show();
              $("#rupiah").hide();
              $("#jenis").show();                    
          }
          else if(x=="rupiah"){
              $("#persen").hide();
              $("#rupiah").show();
              $("#jenis").show();                    
          }
          
      });    
      
  });
</script>
@endpush

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
			  <h2 style="font-size:14pt">PT. SKINSOLUTION INDUSTRI BEAUTY CARE INDONESIA <br>
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
        <label class="col-form-label">{{$inv->invoice_num}}</label>
      </div>
    </div>
    <div class="field item form-group">
      <label class="col-form-label col-md-3 col-sm-3  label-align">No PO : </label>
      <div class="col-md-6 col-sm-6">
        <label class="col-form-label">{{$inv->po_num}}</label>
      </div>
    </div>
  </div>
    <div class="col-md-6 pull-right">
      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">To : </label>
        <div class="col-md-6 col-sm-6">
          <label class="col-form-label">{{$inv->customer_name}}</label>
        </div>
      </div>
      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">PO Date : </label>
        <div class="col-md-6 col-sm-6">
          <label class="col-form-label">1{{$inv->date}}</label>
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
              <th>DESCRIPTION</th>
              <th>QUANTITY</th>														
              <th>PRICE</th>
              <th>TOTAL</th>
						</tr>
					</thead>
					<tbody>
            @if(!empty($podetail->first()))
              @php $total=0; $total1=0;$tamp=0;$tamp2=0; @endphp
                @foreach($podetail as $d)
                  <tr id="row1">
                    <input type="hidden" class="form-control" value='{{$d->id}}' required name="id[]">
                    <input type="hidden" class="form-control" value='{{$inv->id}}' required name="invoice_id[]">
                    <input type="hidden" class="form-control" value='{{$inv->po_product_id}}' required name="po_product_id[]">
                    <td>  {{$d->product->product_name}}</td>
                    <td> {{$d->quantity}}</td>
                    <td>Rp {{number_format($d->product->sale_price,2)}}  </td>
                    <td>Rp {{number_format($d->quantity * $d->product->sale_price,2)}} </td>
                  @php $total1+=($d->quantity * $d->product->sale_price); @endphp
                  </tr>                                            
                  @if(!empty($pack))
                    @foreach($pack as $dt1)
                      <tr id="row1">
                        <td>  {{$dt1->category}} - {{$dt1->packaging_name}}  </td>
                        <td>{{$dt1->quantity}}</td>
                        <td>Rp {{number_format($dt1->price,2)}}  </td>
                        <td>Rp {{number_format($dt1->quantity * $dt1->price,2)}} </td>
                        @php $total1+=($dt1->quantity * $dt1->price); @endphp
                      </tr>                   
                    @endforeach
                  @endif
                  
                  @if(!empty($lab))
                    @foreach($lab as $dt2)
                      <tr id="row1">
                        <td>  {{$dt2->category}} - {{$dt2->packaging_name}}  </td>
                        <td>Rp {{$dt2->quantity}}</td>
                        <td>Rp {{number_format($dt2->price,2)}}  </td>
                        <td>Rp {{number_format($dt2->quantity * $dt2->price,2)}} </td>
                          @php $total1+=($dt2->quantity * $dt2->price); @endphp
                      </tr>
                    @endforeach
                  @endif
                @endforeach
                @if(!empty($invo))
                  @foreach($invo as $dt)
                    @if($dt->jenis=="ya")  
                      <tr id="row1">
                        <td>  {{$dt->description}}  </td>
                        <!--<td>   @if($inv->jenis_invoice=='nondp')  <input type="text" class="form-control" value='{{$dt->quantity}}' required name="quantity[]"> @else {{$dt->quantity}} @endif</td>-->
                        <td>{{$dt->quantity}}</td>
                        <td>Rp {{number_format($dt->price,2)}}  </td>
                        <td>Rp {{number_format($dt->quantity * $dt->price,2)}} </td>
                        @php $total1+=($dt->quantity * $dt->price); @endphp
                      </tr>
                    @endif
                  @endforeach
                @endif
                <tr id="row1">
                  <td colspan="3"><strong>Sub Total</strong></td>
                  <td><strong> Rp {{number_format($total1,2)}} </strong></td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Down Payment</strong></td>
                  @if(($inv->jenis_invoice=='dp' || $inv->jenis_invoice=='nondp') && $inv->jenis_dp=='persen')
                    <td><strong> {{$inv->dp}} % </strong></td>
                    <td><strong> ( Rp {{number_format(($total1 * $inv->dp)/100,2)}} ) </strong></td>
                      
                  @elseif(($inv->jenis_invoice=='dp' || $inv->jenis_invoice=='nondp') && $inv->jenis_dp=='rupiah')
                    <td><strong> </strong></td>
                    <td><strong> ( Rp {{number_format(( $inv->dp),2)}} ) </strong></td>
                      
                  @else($inv->jenis_invoice=='other')
                    <td><strong> </strong></td>
                    <td><strong> ( Rp {{number_format(( $inv->dp),2)}} ) </strong></td>
                  @endif
                </tr>
                @if(!empty($invo))
                  @foreach($invo as $dt)
                    @if($dt->jenis=="tidak")
                      <tr id="row1">
                        <td>{{$dt->description}}  </td>
                        <td>{{$dt->quantity}}</td>
                        <td>Rp {{number_format($dt->price,2)}}  </td>
                        <td>Rp {{number_format($dt->quantity * $dt->price,2)}} </td>
                        @php $tamp+=($dt->quantity * $dt->price); @endphp
                      </tr>
                    @endif
                  @endforeach
                @endif
                @if($inv->jenis_invoice=='nondp')
                  <tr id="row1">
                    @if($inv->jenis_dp=='rupiah')
                      <td colspan="3"><strong>Total</strong></td>
                      <td><strong>Rp {{number_format($total+$total1-($inv->dp) + $tamp,2)}} </strong></td>
                    @else($inv->jenis_dp=='persen')
                      <td colspan="3"><strong>Total</strong></td>
                      <td><strong>Rp {{number_format($total+$total1-(($total1 * $inv->dp)/100) + $tamp,2)}} </strong></td>
                    @endif
                  </tr>
                @else($inv->jenis_invoice=='dp')
                  <tr id="row1">
                    @if($inv->jenis_dp=='rupiah')
                      <td colspan="3"><strong>Total</strong></td>
                      <td><strong> ( Rp {{number_format(($inv->dp + $tamp),2)}} ) </strong></td>
                    @else($inv->jenis_dp=='persen')
                      <td colspan="3"><strong>Total</strong></td>
                      <td><strong> ( Rp {{number_format(($inv->dp/100 * $total1) + ($tamp),2)}} ) </strong></td>
                    @endif  
                  </tr>
                @endif
              @endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endpush