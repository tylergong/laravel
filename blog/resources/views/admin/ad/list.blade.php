@extends('admin.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE'))

@section('navbar')
@include('admin.layouts.navbar')
@endsection

@section('sidebar')
@include('admin.layouts.sidebar')
@endsection


@section('style')
        <!-- DataTables CSS -->
<link href="{{asset('assets/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet">
<!-- Custom Theme JavaScript -->
<link href="{{asset('assets/sb-admin-2/css/sb-admin-2.min.css')}}" rel="stylesheet">
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
            <h1 class="page-header">广告图列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    以下显示当前广告图列表数据
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    @endsection

    @section('script')
            <!-- DataTables JavaScript -->
    <script src="{{asset('assets/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/datatables/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/jquery/jquery.highlight.js')}}"></script>
    <script src="{{asset('data/button.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function () {
            var table = $('#dataTables-example').DataTable({
                dom: "<'row'<'col-md-6'l<'#toolbar'>><'col-md-6'f>r>t<'row'<'col-md-5 sm-center'i><'col-md-7 text-right sm-center'p>>",
                language: {
                    url: "{{asset('data/Chinese.txt')}}"
                },
                searching: true,
                ajax: '/admin/ad',
                deferRender: true,
                ordering: true,
                columns: [
                    {
                        data: "id",
                        title: 'ID',
                    },
                    {
                        data: "imgurl",
                        title: '广告图',
                        render: function (data, type, row, meta) {
                            return '<img src="' + row.imgurl_show + '" height="40px" />';
                        }
                    },
                    {
                        data: "title",
                        title: '说明',
                        render: function (data, type, row, meta) {
                            if (row.is_link == 1) {
                                return '<a target="_blank" href="' + row.jumpurl + '">' + row.title + '</a>';
                            } else {
                                return row.title;
                            }
                        }
                    },
                    {
                        data: "is_link_text",
                        title: '外链',

                    },
                    {
                        data: "create_time",
                        title: '添加时间',

                    },
                    {
                        data: '',
                        title: '操作',
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return "<a class='glyphicon glyphicon-edit' href='/admin/ad/" + row.id + "/edit' title='编辑'></a>" +
                                    "&nbsp;&nbsp;&nbsp;&nbsp;" +
                                    "<a class='glyphicon glyphicon-remove delRow' href='javascript:;' title='删除'></a>";
                        }
                    },
                ],
                order: [[0, 'desc']],
                createdRow: function (row, data, index) {
                    $('td:eq(1),td:eq(3),td:eq(5)', row).css('text-align', "center");
                },
                initComplete: function () {
                    //表格加载完毕，手动添加按钮到表格上
                    $("#toolbar").parent().find('label').css("float", "left").css("margin-right", "10px");
                    $("#toolbar").append("<a href='/admin/ad/create' class='btn btn-primary btn-sm'>添加广告图</a>");
                }
            });

            // 监听 DT 的重绘事件
            table.on('draw', function () {
                //获得需要高亮的容器部分
                var body = $(table.table().body());
                //如果之前有高亮把高亮部分去掉
                body.unhighlight();
                //根据搜索框里的关键字 高亮显示
                body.highlight(table.search());
            });

            // 点击删除按钮
            $('#dataTables-example tbody').on('click', '.delRow', function () {
                var tr = $(this).closest('tr');
                var td = $(this).closest("td");
                var row = table.row(tr);
                swal({
                            title: "Are you sure?",
                            text: "您确认要删除『 " + row.data().id + " 』这个广告图么",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "确认删除",
                            cancelButtonText: "取消",
                            closeOnConfirm: false
                        },
                        function () {
                            $.ajax({
                                type: "DELETE",
                                url: "/admin/ad/" + row.data().id,
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        swal("Good job!", "删除成功了", "success");
                                        row.remove();
                                        table.draw(false);
                                    } else {
                                        swal("No!", "删除失败了，请再次尝试一下吧，若还有问题请去咨询程序猿哥哥吧！", "error");
                                    }
                                },
                            });
                        });
            })

        });
    </script>
@endsection