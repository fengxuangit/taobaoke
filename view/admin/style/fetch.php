{include file='../common_admin/left_bar.php'}

<form enctype="multipart/form-data" method="POST" action="">

    <div class="table_top">
        <div class="table_top_l">共找到({$count})条搭配信息</div>
        <div class="table_top_r">
            <ul>


                <li><a href="{$URL}m=style&a=fetch&cate={$_GET.cate}"><span>全部</span></a></li>


            </ul>
        </div>

    </div>

    <div class="table_main">
        <table class="tb tb2 ">
            <tbody>
            <tr class="hover">
                <th class="td25">选择</th>

                <th>排序</th>
                <th class="goods_title">标题</th>
                <th>标签</th>

                <th>子商品数量</th>

            </tr>
            <!--{foreach from=$fetch item=v}-->

            <tr class="hover">
                <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del"/>
                    <textarea name="data[{$v.id}]" class="hide">{$v.data}</textarea>
                
                </td>
                <td>{$v.id}</td>
                <td class="goods_title {if $v.picurl}_hover_img{/if}">
                    {$v.title}
                    {if $v.picurl}<a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"/></a>{/if}
                </td>
                <td>
                    {$v.cate}
                </td>

                <td>{$v.length}</td>


            </tr>
            <!--{/foreach}-->
            <tr>
                <td class="td25"><input type="checkbox" class="_del_all"/>
                    反选
                </td>

                <td colspan="6">
                    <div class="y">{$showpage}</div>
                    <div class="fixsel">

                        <input type="submit" class="btn submit_btn" name="onsubmit" value=" 提 交">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="cate" value="{$_GET.cate}"/>
    <input type="hidden" name="m" value="{$CURMODULE}"/>
    <input type="hidden" name="a" value="{$CURACTION}"/>
</form>
{include file='../common_admin/right_bar.php'} 