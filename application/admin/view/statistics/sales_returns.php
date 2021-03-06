{if $this->t_verify->is_post() && $this->t_verify->is_ajax()}
<?php if (count($list) == 0) { ?>
<p class="bg-warning center-block">   
    <i class="iconfont icon-wushuju"></i> 暂时没有相关数据
</p>
{else}

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>退货日期</th>
            <th>会员</th>
            <th>操作人</th>
            <th>退货数量</th>
            <th>入库</th>
            <th>出库</th>
            <th>积分变更</th>
            <th>产品识别码</th>
            <th>产品名称</th>
            <th>产品分类</th>
            <th>产品备注</th>
            <th style="width:70px;text-align:center">订单</th>
        </tr>
    </thead>
    <tbody>
        {volist name="list" id="var"}
        {_ $var.product_data=unserialize($var.product_data);}
        <tr>
            <td>{:sprintf("%06d",$var.id)}</td>
            <td>{{$var.create_time}}</td>
            <td>{$var.membernickname}</td>
            <td>{$var.nickname}</td>
            <td>{$var.quantity}</td>
            <td>{$var.w_name}</td>
            <td>{$var.w_name2}</td>
            <td>{$var.is_points?'<i class="icon-ok"></i>':''}</td>
            <td>{$var.product_data.code}</td>
            <td>{$var.product_data.name}</td>
            <td>{$var.product_data.category}</td>
            <td title="{$var.remark}">{$var.remark}</td>
            <td style="text-align:center"><a href="{site 'inventory/product_sales_look/'.$var.ordersid}" title="查看产品"><i class="iconfont icon-sousuo"></i> 查看</a></td>
        </tr>

        {/volist}

    </tbody>
</table>




{/if}
{else}
{view 'public/head'}
</head>
<body>
    <div class="container-fluid">
        <form id="forminventorysupplier" class="form-inline" action="{site 'statistics/sales_returns/'.$py}" accept-charset="utf-8" method="get">
            <table class="table table-hover">
                <tbody>

                    <tr>
                        <td>
                            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">
                            <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
                            <i class="icon-resize-horizontal"></i>
                            <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">
                            <div class="btn-group" data-toggle="buttons-radio">
                                <button type="button" onclick="$('#chartinput').val(0); $('form').submit()" class="btn{empty($chart)?' active':''}"><i class="icon-bar-chart"></i> 宏观图</button>
                                <button type="button" onclick="$('#chartinput').val(1); $('form').submit()" class="btn{$chart==='1'?' active':''}"><i class="icon-table"></i> 表格</button>
                            </div>
                            <input type="hidden" id="chartinput" name="chart" value="{$chart}" />

                            <button type="submit" class="btn btn-primary" title="查询"><i class="iconfont icon-sousuo"></i> 搜索</button>
                            <button class="btn" type="button" onclick="$('.more_search').fadeToggle(); $('#financequerysearch').val($('#financequerysearch').val() == 1?0:1)"><i class="fa fa-rss"></i> 更多</button>

                            

                            <input type="hidden" id="page" name="page" value="1" />
                            <input type="hidden" id="countinput" name="count" value="{$count}" />
                        </td>
                    </tr>
                    <tr class="more_search" {eq name="Think.request.financequerysearch" value="1"}style="display:none"{/eq}>
                        <td>
                            <input type="hidden" name="financequerysearch" id="financequerysearch" value="{$Think.request.financequerysearch?:0}" />

                            <input type="text" placeholder="订单号" name="number" value="{$Think.request.number}" class="form-control">
                            <input type="text" placeholder="会员姓名" name="nickname" value="{$Think.request.nickname}" class="form-control">
                            <input type="text" placeholder="会员卡号" name="card" value="{$Think.request.card}" class="form-control">
                            <input type="text" name="id_card" value="{$Think.request.id_card}" placeholder="会员身份证号" class="form-control">
                            <input type="text" placeholder="会员电话" name="card" value="{$Think.request.tel}" class="form-control">
                            <input type="text" placeholder="会员QQ" name="qq" value="{$Think.request.qq}" class="form-control">
                            <select name="type" class="form-control">
                                <option value="">类型</option>
                                <option value="1"{eq name="Think.request.type" value="1"} selected{/eq}>正常</option>
                                <option value="2"{eq name="Think.request.type" value="2"} selected{/eq}>赠品</option>
                            </select>
                        </td>

                    </tr>
                    <tr class="more_search" {eq name="Think.request.financequerysearch" value="1"}style="display:none"{/eq}>
                        <td>
                            <select name="warehouse" class="form-control">
                                <option value="">入库</option>
                                {volist name="warehouse" id="var"}
                                <option value="{$var.w_id}"{eq name="Think.request.warehouse" value="$var.w_id"} selected{/eq}>{$var.w_name}</option>
                                {/volist}
                            </select>
                            <select name="warehouse2" class="form-control">
                                <option value="">出库</option>
                                {volist name="warehouse" id="var"}
                                <option value="{$var.w_id}"{eq name="Think.request.warehouse2" value="$var.w_id"} selected{/eq}>{$var.w_name}</option>
                                {/volist}
                            </select>
                            <select name="c_id" class="form-control">
                                <option value="">所有分类</option>
                                {$category}
                            </select>

                           
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>
        {if empty($chart)}
         <p>
            <small><i class="iconfont icon-wushuju"></i> 合计退回:<strong>{:array_sum($list.return)}</strong>个</small>
        </p>
        <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>

        {else}
        <p>
            <small><i class="iconfont icon-wushuju"></i> 查询到了<strong>{$count}</strong>个销售记录，合计退回:<strong>{:array_sum($list.return)}</strong>个</small>
        </p>
        <div id="tablelist">

        </div>
        <div class="pagination text-center">
            <ul id='pagination'>

            </ul>
        </div>
        {/if}

    </div>
    {view 'public/js'}
    {if empty($chart)}
    {js 'assets/echarts/esl/esl.js'}
    {js 'assets/echarts/echarts-plain.js'}
    <script type="text/javascript">
                option = {
                title : {
                text: '销售退货宏观图',
                        subtext: '{$Think.request.timea}至{$Think.request.timeb}'
                },
                        tooltip : {
                        trigger: 'axis'
                        },
                        legend: {
                        data:['退回']
                        },
                        toolbox: {
                        show : true,
                                feature : {
                                mark : {show: true},
                                        dataView : {show: true, readOnly: false},
                                        magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                        restore : {show: true},
                                        saveAsImage : {show: true}
                                }
                        },
                        calculable : true,
                        xAxis : [
                        {
                        type : 'category',
                                boundaryGap : false,splitLine : {show : false},
                                data : [{implode(',', $list.date)}]
                        }
                        ],
                        yAxis : [
                        {
                        type : 'value'
                        }
                        ],
                        series : [
                        {
                        name:'退回',
                                type:'line',
                                smooth:true,
                                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                data:[{implode(',', $list.return)}],
            markLine : {
                data : [
                    {type : 'average', name : '平均值'}
                ]
            }
                        }
                        ]
                };
                echarts.init(document.getElementById('main')).setOption(option);</script>
    {else}
    <script type="text/javascript">
                $(document).ready(function() {
        {if !empty($count)}
        $('#pagination').jqPaginator({
        totalCounts: {$count},
                pageSize:{:config('LIST_ROWS')},
                currentPage: 1,
                onPageChange: function(num, type) {
                $('#paginationinput').val(num);
                        $.post($('#forminventorysupplier').attr('action'), $('#forminventorysupplier').serialize(), function(data) {
                        $('#tablelist').html(data);
                        });
                }
        });
        {/if}

        });
    </script>
    {/if}
</body>
</html>
{/if}