
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('site-title')</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="{{ asset('css/breadcrumb.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('assets/vendors/nprogress/nprogress.css" rel="stylesheet')}}">
    <!-- iCheck -->
    <link href="{{ asset('assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet')}}">
    <!-- data table -->
    <link href="{{ asset('assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
   
    <!-- Custom styling plus plugins -->
    <link href="{{ asset('assets/build/css/custom.min.css')}}" rel="stylesheet">
    <style>
      #printable { display: none; }

      @media print
      {
          #non-printable { display: none; }
          #printable { display: block; }
      }
    </style>
    @stack('styles')
  </head>

  <body class="nav-md">
    <div class="container body" id="non-printable">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('assets/src/img/logo.png')}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <h2>Skinsolution Industri</h2>
                <span>ERP</span>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            @if(Auth::user()->role == 0)
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="{{ url('home') }}"><i class="fa fa-home"></i> Home</a></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>MASTER</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-cubes"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('materials.index') }}">Materials</a></li>
                      <li><a href="{{ route('packagings.index') }}">Packaging</a></li>
                      <li><a href="{{ route('suppliers.index') }}">Supplier</a></li>
                      <li><a href="{{ route('principals.index') }}">Principal</a></li>
                      <li><a href="{{ route('samples.index') }}">Sample Materials</a></li>
                      <li><a>Purchase Order<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{ route('po_material.index') }}">Materials</a></li>
                            <li><a href="{{ route('po_packaging.index') }}">Packaging</a></li>
                          </ul>
                      </li>
                      <li><a>Penerimaan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{route('purchases_material.index')}}">Materials</a></li>
                            <li><a href="{{ route('packaging_receipt.index') }}">Packaging</a></li>
                            <li><a href="{{ route('income_samples.index') }}">Sample</a></li>
                          </ul>
                      </li>
                      <li><a>Stok<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{url('/materials_stocks')}}">Materials</a></li>
                            <li><a href="{{url('/packagings_stocks')}}">Packaging</a></li>
                            <li><a href="{{url('/samples_stocks')}}">Sample</a></li>
                          </ul>
                      </li>
                      <li><a>Estimasi Pemesanan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{route('estimasi_material.index')}}">Materials</a></li>
                            <li><a href="{{route('estimasi_packaging.index')}}">Packaging</a></li>
                          </ul>
                      </li>                   
                    </ul>
                  </li>
                  <li><a><i class="fa fa-diamond"></i> Produksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('formula.index') }}">Formula</a></li>
                      <li><a>Trial<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{ route('trial.index') }}">Data</a></li>
                            <li><a href="{{ route('trial_revisi.index') }}">Revisi</a></li>
                          </ul>
                      </li>
                      <li><a href="{{ route('produksi.index') }}">Product</a></li>
                      <li><a>Kegiatan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{ route('activity_product.index') }}">Produksi</a></li>
                            <li><a href="{{ route('activity_packaging.index') }}">Packaging</a></li>
                            <li><a href="{{ route('labelling.index') }}">Labelling</a></li>
                          </ul>
                      </li>
                      <li><a href="{{ route('produksi.stoct') }}">Stok Produk</a></li>
                      <li><a href="{{ route('retur.index') }}">Retur</a></li>
                      <li><a>Pengeluaran Bahan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{ route('pengeluaran_material.index') }}">Material</a></li>
                            <li><a href="{{ route('pengeluaran_ruahan.index') }}">Ruahan</a></li>
                            <li><a href="{{ route('pengeluaran_packaging.index') }}">Packaging</a></li>
                            <li><a href="{{ route('pengeluaran_labelling.index') }}">Labelling</a></li>
                            <li><a href="{{ route('pengeluaran_packaging2.index2') }}">Hasil Packaging</a></li>
                            <li><a href="{{ route('pengeluaran_labelling2.index2') }}">Hasil Labelling</a></li>
                          </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a href="{{ route('user_management.index')}}"><i class="fa fa-users"></i> User Management</a></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>TRANSAKSI</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-shopping-cart"></i> Pemesanan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('customers.index') }}">Customer</a></li>
                      <li><a>Purchase Order<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{route('po_customer.index')}}">Trial</a></li>
                            <li><a href="{{route('po_product_pemesanan.index')}}">Produksi</a></li>
                          </ul>
                      </li>
                      <li><a href="{{route('delivery_order.index')}}">Delivery Order</a></li>
                      <li><a href="{{route('history.index')}}">History</a></li>
                      <li><a href="{{route('left_overs.index')}}">Leftovers</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-usd"></i> Accounting <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a>Pengeluaran<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{url('accounting_POmaterial')}}">PO Material</a></li>
                            <li><a href="{{url('accounting_POpackaging')}}">PO Packaging</a></li>
                            <li><a href="{{route('pengeluaran_lain.index')}}">PO Lain-Lain</a></li>
                            <li><a href="{{route('pengeluaran_gaji.index')}}">Gaji</a></li>
                          </ul> 
                      </li>
                      <li><a>Pemasukan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{route('penjualan.index')}}">Penjualan</a></li>
                            <li><a href="{{route('invoice.index')}}">Invoice</a></li>
                            <li><a href="#level2_2">Pembayaran Invoice</a></li>
                          </ul>
                      </li>
                      <li><a href="{{route('bayar.notif_po')}}">Notifikasi Pembayaran PO</a></li>
                      <li><a href="{{route('petty.index')}}">Cash Flow</a></li>
                    </ul>
                  </li>
                  <li><a href="http://customer.skinsolutionindustri.co.id/"><i class="fa fa-user"></i> Customer </a></li>
                  <li><a href="http://hrd.skinsolutionindustri.co.id/"><i class="fa fa-credit-card"></i> HRD</span></a></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>LAPORAN</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-file-text"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('laporan.pemasukkan')}}">Laporan Pemasukan</a></li>
                      <li><a href="{{route('laporan.pengeluaran')}}">Laporan Pengeluaran</a></li>
                      <li><a href="{{route('laba.index')}}">Laporan Laba</a></li>
                      <li><a href="e_commerce.html">Laporan Hutang</a></li>
                      <li><a href="e_commerce.html">Laporan Piutang</a></li>
                      <li><a href="e_commerce.html">Laporan Bonus</a></li>
                      <li><a href="e_commerce.html">Laporan Asuransi</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
            @elseif(Auth::user()->role == 8)
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="{{ url('home') }}"><i class="fa fa-home"></i> Home</a></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>CUSTOMER</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('produksi.index') }}"><i class="fa fa-diamond"></i> Product</a></li>
                  <li><a href="{{ route('packagings.index') }}"><i class="fa fa-cubes"></i> Packaging</a></li>
                  <li><a><i class="fa fa-cube"></i> Stock <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('produksi.stoct') }}">Product</a></li>
                      <li><a href="{{url('/packagings_stocks')}}">packaging</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-th-large"></i> Kegiatan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="sub_menu"><a href="{{ route('activity_product.index') }}">Produksi</a></li>
                      <li><a href="{{ route('activity_packaging.index') }}">Packaging</a></li>
                      <li><a href="{{ route('labelling.index') }}">Labelling</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-shopping-cart"></i> Purchase Order <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('po_product_pemesanan.index')}}">Produksi</a></li>
                      <li><a href="{{route('po_customer.index')}}">Trial</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-truck"></i> Pengiriman <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('delivery_order.index')}}">Delivery Order</a></li>
                      <li><a href="{{route('history.index')}}">History</a></li>
                      <li><a href="{{route('left_overs.index')}}">Leftovers</a></li>
                    </ul>
                  </li>
                  <li><a href="{{route('invoice.index')}}""><i class="fa fa-file-text"></i> Invoice</a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
            @endif
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="{{ asset('assets/src/img/logo.png')}}" alt="">
                      @if(Auth::user()->role == 0)
                        PT. Skinsolution Industri
                      @else
                        {{Auth::user()->name}}
                      @endif
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a data-toggle="modal" href="#changePss" class="dropdown-item"><i class="fa fa-cogs pull-right"></i> Change Password</a>
                      <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->
        <!-- modal add -->
        <div class="modal fade bd-example-modal-lg" id="changePss" tabindex="-1" role="dialog" aria-labelledby="changePssLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="changePssLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('admin.change', Auth::user()->id)}}" role="form" method="post">
                  @method('PUT')
                  {{csrf_field()}}

                  <div class="form-group">
                    <label class="control-label col-md-2">Password</label>
                    <input name='password' type='password' class='form-control' required>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Retype Password</label>
                    <input name='re_password' type='password' class='form-control' required>
                  </div>

                  <div class="modal-footer">
                    <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            @include('layouts.message')
            @yield('content')
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <div class="container body" id="printable">
      <div class="main_container">
        <div class="right_col" role="main">
          @stack('print')
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
   <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{ asset('assets/vendors/nprogress/nprogress.js')}}"></script>
    <!-- iCheck -->
    <script src="{{ asset('assets/vendors/iCheck/icheck.min.js')}}"></script>

    @stack('beforeScripts')

      <!-- Datatables -->
    <script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/vendors/nprogress/nprogress.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('assets/build/js/custom.min.js')}}"></script> 

    <!-- sweetalert -->
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js')}}"></script>
    
    @stack('scripts')

  </body>
</html>