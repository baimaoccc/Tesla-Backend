define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index' + location.search,
                    multi_url: 'order/multi',
                    import_url: 'order/import',
                    table: 'order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'states', title: __('状态'),operate: false,formatter:Table.api.formatter.toggle,color:"green", yes:"1", no:"0", disable:function(value, row, index){ return true; }},
                        {field: 'ad', title: __('广告ID'), operate:'RANGE'},
                        {field: 'email', title: __('邮箱'), operate:'RANGE'},
                        {field: 'username', title: __('用户名'), operate:'RANGE'},
                        {field: 'documentFront', title: __('证件正面'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'documentBack', title: __('证件反面'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'userSelfPictureOrVideo', title: __('视频'), operate: false, events: Table.api.events.video, formatter: Table.api.formatter.video},
                        
                        // {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('更新时间'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
