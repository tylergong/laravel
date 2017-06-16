@extends('layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE').'--列表')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
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
            <h1 class="page-header">活动列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
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
                ajax: '/dataTable',
                //ordering: false,
                columns: [
                    {
                        data: null,
                        className: 'details-control',
                        defaultContent: '',
                    },
                    {
                        data: "id",
                        title: 'ID',
                        orderable: false,
                    },
                    {
                        data: '',
                        title: '移位',
                        render: function (data, type, row, meta) {
                            return Button.up + '&nbsp;&nbsp;' + Button.down
                        }
                    },
                    {
                        data: "name",
                        title: '活动名称',
                        render: function (data, type, row, meta) {
                            if (row.is_vip > 0) {
                                return '<div style="width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text:bold;color:#DD6B55"> ' + row.name + '</div>';
                            } else {
                                return '<div style="width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"> ' + row.name + '</div>';
                            }
                        }
                    },
                    {
                        data: "list_img_format",
                        title: "列表图片",
                        render: function (data, type, row, meta) {
                            return (data) ? '<img src=' + data + ' style="width:50px;height:20px" />' : '';
                        }
                    },
                    {
                        data: "main_text",
                        title: "主体",
                    },
                    {
                        data: "act_rule_type_text",
                        title: "类型",
                    },
                    {
                        data: "matter_type_text",
                        title: "物料",
                    },
                    {
                        data: null,
                        title: "活动期限",
                        render: function (data, type, row, meta) {
                            return row.start_time_format + '至' + row.end_time_format;
                        }
                    },
                    {
                        data: "click_num",
                        title: '参与人数	',
                    },
                    {
                        data: null,
                        title: '推送	',
                        className: 'c-push',
                        render: function (data, type, row, meta) {
                            var $_html = '';
                            if (row.status == 1 && row.is_stop == 0) {
                                if (row.push_num == 0) {
                                    $_html = Button.one_push;
                                } else if (row.push_num == 1) {
                                    $_html = Button.two_push;
                                } else if (row.push_num == 2) {
                                    $_html = Button.no_push;
                                }
                            }
                            return $_html;
                        }
                    },
                    {
                        data: 'status',
                        title: '发布状态',
                        className: 'c-status',
                        render: function (data, type, row, meta) {
                            var $_html = "";
                            if (row.is_stop == 0) {
                                if (row.status == -1) {
                                    $_html = Button.overdue;
                                } else if (row.status == 1) {
                                    $_html = Button.released;
                                } else if (row.status == 0) {
                                    $_html = Button.pending;
                                }
                            }
                            return $_html;
                        }
                    },
                    {
                        data: 'is_stop',
                        title: '终止状态',
                        render: function (data, type, row, meta) {
                            var $_html = '';
                            if (row.is_stop == -1) {
                                $_html = Button.stop;
                            } else if (row.is_stop == 0) {
                                $_html = Button.normal;
                            }
                            return $_html;
                        }
                    },
                    {
                        data: 'is_show_list',
                        title: '列表显示',
                        className: 'c-show',
                        render: function (data, type, row, meta) {
                            var $_html = '';
                            if (row.is_stop == 0) {
                                if (row.is_show_list == 1) {
                                    $_html = Button.show;
                                } else if (row.is_stop == 0) {
                                    $_html = Button.no_show;
                                }
                            }
                            return $_html;
                        }
                    },
                    {
                        data: '',
                        title: '操作',
                        render: function (data, type, row, meta) {
                            return Button.edit_act + '&nbsp;&nbsp;&nbsp;&nbsp;' + Button.export_order;
                        }
                    },
                ],
                //order: [[1, 'desc']],
                createdRow: function (row, data, index) {
                    $('td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(9),td:eq(10),td:eq(11),td:eq(12),td:eq(13),td:eq(14),td:eq(15)', row).css('text-align', "center");
                },
                initComplete: function () {
                    //表格加载完毕，手动添加按钮到表格上
                    $("#toolbar").parent().find('label').css("float", "left").css("margin-right", "10px");
                    $("#toolbar").append("<a href='#' class='btn btn-primary btn-sm'>添加活动</a>");
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

            // 点击首列图标展开，显示行的附加信息
            $('#dataTables-example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            // 点击PUSH按钮，发布消息
            $('#dataTables-example tbody').on('click', '.changePush', function () {
                var tr = $(this).closest('tr');
                var td = $(this).closest("td");
                var row = table.row(tr);
                swal({
                        title: "Are you sure?",
                        text: "你的本次操作会将活动 《" + row.data().name + "》 的讯息发送到相关用户的手中！",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "是的，发送！",
                        cancelButtonText: "取消",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            type: "POST",
                            url: "/dataTable/setPushNum",
                            dataType: "json",
                            data: {'id': row.data().id},
                            success: function (response) {
                                if (response) {
                                    var _html = '';
                                    if (row.data().push_num == 0) {
                                        _html = Button.two_push;
                                        row.data().push_num = 1;
                                    } else if (row.data().push_num == 1) {
                                        _html = Button.no_push;
                                    }
                                    td.html(_html);
                                    swal("Good job!", "您已成功发送了消息，心里是不是小小的激动了一下呢？一大波用户都将过来参与您的活动哦！", "success");
                                } else {
                                    swal("No!", "消息发送失败了，请再次尝试一下吧，若还有问题请去咨询程序猿哥哥吧！", "error");
                                }
                            },
                        });
                    });
            });

            // 点击改变活动状态
            $('#dataTables-example tbody').on('click', '.changeStatus', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                var td = $(this).closest("td");
                var td2 = $(this).parents("tr").children('.c-push')
                var str1, str2 = "";
                if (row.data().status == 0) {
                    str1 = "你的本次操作将会活动 《" + row.data().name + "》 的状态改为『已发布』!";
                    str2 = "您已成功改变了当前活动的发布状态，祝愿您的活动一路顺畅，大红大紫哦！"
                } else if (row.data().status == 1) {
                    str1 = "你的本次操作将会将活动 《" + row.data().name + "》 的状态改为『下线』!";
                    str2 = "您已成功改变了当前活动的发布状态，很遗憾这个活动会下线，期待您的下一次活动哦！"
                }
                swal({
                        title: "Are you sure?",
                        text: str1,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "是的，改变他！",
                        cancelButtonText: "取消",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            type: "POST",
                            url: "/dataTable/setStatus",
                            dataType: "json",
                            data: {'id': row.data().id},
                            success: function (response) {
                                if (response) {
                                    var _html = '';
                                    var _html2 = '';
                                    if (row.data().status == 0) {
                                        _html = Button.released;
                                        row.data().status = 1
                                        if (row.data().push_num == 0) {
                                            _html2 = Button.one_push;
                                        } else if (row.data().push_num == 1) {
                                            _html2 = Button.two_push;
                                        } else if (row.data().push_num == 2) {
                                            _html2 = Button.no_push;
                                        }
                                    } else if (row.data().status == 1) {
                                        _html = Button.pending;
                                        row.data().status = 0
                                    }
                                    td.html(_html);
                                    td2.html(_html2)
                                    swal("Good job!", str2, "success");
                                } else {
                                    swal("No!", "修改失败了，请再次尝试一下吧，若还有问题请去咨询程序猿哥哥吧！", "error");
                                }
                            },
                        });

                    });
            });

            // 点击改变活动状态2(提前终止活动)
            $('#dataTables-example tbody').on('click', '.changeStop', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                var td = $(this).closest("td");
                var td2 = $(this).parents("tr").children('.c-push');
                var td3 = $(this).parents("tr").children('.c-status');
                var td4 = $(this).parents("tr").children('.c-show');
                var str1 = "您的本次操作将会活动 《" + row.data().name + "》 的提前『终止』!";
                var str2 = "您已成功改变了当前活动的状态，很遗憾这个活动被终止了，期待您的下一次活动哦！";
                swal({
                        title: str1,
                        text: "请输入终止原因:",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "请输入终止原因",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "是的，提前终止！",
                        cancelButtonText: "取消"
                    },
                    function (inputValue) {
                        if (inputValue === false)  return false;

                        if (inputValue === "") {
                            swal.showInputError("请输入您要终止本次活动的原因!");
                            return false
                        }

                        $.ajax({
                            type: "POST",
                            url: "/dataTable/setStop",
                            dataType: "json",
                            data: {'id': row.data().id, 'title': inputValue},
                            success: function (response) {
                                if (response) {
                                    row.data().is_stop = -1;
                                    td.html(Button.stop);
                                    td2.html('');
                                    td3.html('');
                                    td4.html('');
                                    swal(str2, "您输入的原因是：" + inputValue, "success");
                                } else {
                                    swal("No!", "修改失败了，请再次尝试一下吧，若还有问题请去咨询程序猿哥哥吧！", "error");
                                }
                            },
                        });


                    });
            });

            // 点击改变活动在列表显示
            $('#dataTables-example tbody').on('click', '.changeListShow', function () {
                var tr = $(this).closest('tr');
                var td = $(this).closest("td");
                var row = table.row(tr);
                var str1, str2, str3 = "";
                if (row.data().is_show_list == 0) {
                    str1 = "您的本次操作会设置活动 《" + row.data().name + "》 在列表中显示！";
                    str2 = "您已成功改变了当前活动的显示状态，在列表中已经『上架』，祝愿您的活动一路顺畅，大红大紫哦！"
                    str3 = "『 上架 』";
                } else if (row.data().is_show_list == 1) {
                    str1 = "您的本次操作将会设置活动 《" + row.data().name + "》 从列表中『下架』!";
                    str2 = "您已成功改变了当前活动的显示状态，『下架』后当前活动还是可以参加的哦，只是不会出现在列表中了！"
                    str3 = "『 下架 』";
                }
                swal({
                        title: "Are you sure?",
                        text: str1,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: str3,
                        cancelButtonText: "取消",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            type: "POST",
                            url: "/dataTable/setShowList",
                            dataType: "json",
                            data: {'id': row.data().id},
                            success: function (response) {
                                if (response) {
                                    var _html = '';
                                    if (row.data().is_show_list == 0) {
                                        _html = Button.show;
                                        row.data().is_show_list = 1;
                                    } else if (row.data().is_show_list == 1) {
                                        _html = Button.no_show;
                                        row.data().is_show_list = 0;
                                    }
                                    td.html(_html);
                                    swal("Good job!", str2, "success");
                                } else {
                                    swal("No!", "修改失败了，请再次尝试一下吧，若还有问题请去咨询程序猿哥哥吧！", "error");
                                }
                            },
                        });
                    });
            });

            // 向上移位
            $('#dataTables-example tbody').on('click', '.changeOrderByUp', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var index = row.index();
                var data = table.data();
                $.ajax({
                    type: "POST",
                    url: "/dataTable/setOrderBy",
                    dataType: "json",
                    data: {'id': row.data().id, 'opt': 'up'},
                    success: function (response) {
                        if (response) {
                            table.clear();
                            data.splice((index - 1), 0, data.splice(index, 1)[0]);
                            table.rows.add(data);
                            table.draw(false);
                        } else {
                            swal("亲，已经到顶了")
                        }
                    },
                });
            });

            // 向下移位
            $('#dataTables-example tbody').on('click', '.changeOrderByDown', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var index = row.index();
                var data = table.data();
                $.ajax({
                    type: "POST",
                    url: "/dataTable/setOrderBy",
                    dataType: "json",
                    data: {'id': row.data().id, 'opt': 'down'},
                    success: function (response) {
                        if (response) {
                            table.clear();
                            data.splice((index + 1), 0, data.splice(index, 1)[0]);
                            table.rows.add(data);
                            table.draw(false);
                        } else {
                            swal("亲，已经到底了")
                        }
                    },
                });
            });


        });


        /* 格式化需要展开显示的信息 */
        function format(d) {
            // `d` 必须是原始行的数据项
            $_html = '<table  border="0" style="padding-left:50px;height: 100px;">' +
                '<tr>' +
                '<td>活动名称全称:</td>' +
                '<td>&nbsp;&nbsp;</td>' +
                '<td>' + d.name + '</td>' +
                '</tr>';
            if (d.is_vip == 1) {
                $_html += '<tr>' +
                    '<td>VIP 属性:</td>' +
                    '<td>&nbsp;&nbsp;</td>' +
                    '<td>参加该活动要求VIP</td>' +
                    '</tr>';
            } else if (d.is_vip == 2) {
                $_html += '<tr>' +
                    '<td>VIP 属性:</td>' +
                    '<td>&nbsp;&nbsp;</td>' +
                    '<td>参加该活动要求年付VIP</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>年VIP购买区间:</td>' +
                    '<td>&nbsp;&nbsp;</td>' +
                    '<td>' + d.buy_vip_time1_format + '至' + d.buy_vip_time2_format + '</td>' +
                    '</tr>';
            }
            $_html += '<tr>' +
                '<td>其他说明:</td>' +
                '<td>&nbsp;&nbsp;</td>';
            if (d.is_stop == -1) {
                $_html += '<td>改活动已经于『' + d.stop_time_format + '』被提前终止，终止原因是『' + d.stop_title + '』</td>';
            } else {
                $_html += '<td>。。。。。。</td>';
            }
            $_html += '</tr>' +
                '</table>';
            return $_html;
        }
    </script>
@endsection