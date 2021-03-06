{extend name="base:base" /} {block name="body"} 

<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="<?php echo url('product') ?>"><i class="iconfont icon-flow"></i> 返回列表</a>
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button>
    </div>
</div>
<form class="form-horizontal container" action="{:url('product_add')}" method="post">
    {$tpl_form}
</form>
{/block}
{block name="foot_js"} 
<script type="text/javascript">
    $(function () {
        $('#autocomplete').autocomplete({
            serviceUrl: "{:url('json/product')}",
            onSelect: function (suggestion) {
                $('#productid').val(suggestion.id);
                $('#inventorystorage').attr('action', '{:url('inventory / storage')}');
                $('#inventorystorage').attr('ajax', 'no')
                $('#inventorystorage').submit();
            }
        });
    });
</script>{/block}
