
  <table class="tb tb2 nobdb">
     <tbody>


      <tr>
          <td colspan="3">{$start}-{$end}的APP使用情况</td>
        </tr>
     <tr class="noborder">
          <td class="td_l" colspan="1">时间</td>

          <td class="td_l" colspan="1">今天的操作数</td>
        </tr>
     
      {foreach from=$data item=v key=k}
       <tr>
         <td class="td_l" colspan="1">{$v.reportDate}</td>

  </tr>
      {/foreach}
    
     </tbody>
  </table>

