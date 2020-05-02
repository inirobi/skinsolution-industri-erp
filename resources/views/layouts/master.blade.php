
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

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

    @stack('styles')
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
            </div>
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('assets/build/images/Logo.png')}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Skin</span>
                <h2>Solution</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

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
                            <li class="sub_menu"><a href="level2.html">Materials</a></li>
                            <li><a href="#level2_2">Packaging</a></li>
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
                      <li><a href="{{ route('produksi.index') }}">Produk</a></li>
                      <li><a>Kegiatan<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Produksi</a></li>
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
                  <li><a href="#"><i class="fa fa-users"></i> User Management</a></li>
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
                            <li class="sub_menu"><a href="level2.html">Trial</a></li>
                            <li><a href="#level2_2">Produksi</a></li>
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
                            <li><a href="#level2_2">Invoice</a></li>
                            <li><a href="#level2_2">Pembayaran Invoice</a></li>
                          </ul>
                      </li>
                      <li><a href="pricing_tables.html">Notifikasi Pembayaran PO</a></li>
                    </ul>
                  </li>
                  <li><a href="#"><i class="fa fa-user"></i> Customer </a></li>
                  <li><a href="#"><i class="fa fa-credit-card"></i> Penggajian</span></a></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>LAPORAN</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-file-text"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">Laporan Pemasukan</a></li>
                      <li><a href="e_commerce.html">Laporan Pengeluaran</a></li>
                      <li><a href="e_commerce.html">Laporan Laba</a></li>
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

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
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
                      <img src="{{ asset('images/img.jpg')}}" alt="">John Doe
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="javascript:;">
                          <span class="badge bg-red pull-right">50%</span>
                          <span>Settings</span>
                        </a>
                    <a class="dropdown-item"  href="javascript:;">Help</a>
                      <a class="dropdown-item"  href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </li>
  
                  <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green">6</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ asset('images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ asset('images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ asset('images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ asset('images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <div class="text-center">
                          <a class="dropdown-item">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->

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