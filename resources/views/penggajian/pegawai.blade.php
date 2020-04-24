@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>Data Pegawai</h3>
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
          <h2>Button Example <small>Users</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>No Telpon</th>
                <th>Alamat</th>
                <th>Gaji</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($employees as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td class="avatar text-center">
                  <img class="rounded-circle" src="assets/build/images/avatar5.png" alt="">
                </td>
                <td>{{ $data -> name }}</td>
                <td>{{ $data -> phone }}</td>
                <td>{{ $data -> local_add }}</td>
                <td>${{ $data -> salary }}</td>
                <td class="text-center">
                  <a href="#"><button class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button></a>
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
@endsection