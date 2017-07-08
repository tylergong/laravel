@extends('admin.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE').'--列表')

@section('navbar')
@include('admin.layouts.navbar')
@endsection

@section('sidebar')
@include('admin.layouts.sidebar')
@endsection


@section('style')
        <!-- DataTables CSS -->
<link href="{{asset('assets/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
    td.details-control {
        background: url({{asset('assets/datatables/images/details_open.png')}}) no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url({{asset('assets/datatables/images/details_close.png')}}) no-repeat center center;
    }

    a {
        cursor: pointer;
    }

    table.dataTable span.highlight {
        background-color: #FFFF88;
        border-radius: 0.28571429rem;
    }

    table.dataTable span.column_highlight {
        background-color: #ffcc99;
        border-radius: 0.28571429rem;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">主页</div>

                <div class="panel-body">
                    欢迎您! {{ auth('admin')->user()->name }}
                </div>
            </div>
        </div>
    </div>
@endsection
