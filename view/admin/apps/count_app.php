
  <table class="tb tb2 nobdb">
     <tbody>

      <tr>
           <td colspan="3">{$start}-{$end}的APP使用情况</td>
        </tr>
     <tr class="noborder">
          <td class="td_l" colspan="1">时间</td>
          <td class="td_l" colspan="1">设备总数</td>
          <td class="td_l" colspan="1">当天新注册用户数</td>
          <td class="td_l" colspan="1">当天新升级用户数</td>
          <td class="td_l" colspan="1">当天活跃用户数</td>
          <td class="td_l" colspan="1">七日内活跃用户数</td>
          <td class="td_l" colspan="1">三十日内活跃用户数</td>
          <td class="td_l" colspan="1">应用累计使用时长</td>
          <td class="td_l" colspan="1">应用累计使用次数</td>

          <!-- <td class="td_l" colspan="1">30天总使用时间</td>
          <td class="td_l" colspan="1">7天总操作数</td>
          <td class="td_l" colspan="1">30天总操作数</td> -->
          <td class="td_l" colspan="1">今天使用的时间</td>
          <td class="td_l" colspan="1">今天的操作数</td>
        </tr>
     
      {foreach from=$data item=v key=k}
       <tr>
         <td class="td_l" colspan="1">{$v.reportDate}</td>
         <td class="td_l" colspan="1">{$v.devicesCount}</td>
         <td class="td_l" colspan="1">{$v.newRegsCount}</td>
         <td class="td_l" colspan="1">{$v.newUpdateCount}</td>
         <td class="td_l" colspan="1">{$v.activeCountInToday}</td>
         <td class="td_l" colspan="1">{$v.activeCountInSevenDays}</td>
         <td class="td_l" colspan="1">{$v.activeCountInThirtyDays}</td>
         <td class="td_l" colspan="1">{$v.totalUseTime}分钟</td>
         <td class="td_l" colspan="1">{$v.totalOperationCount}</td>

         <!-- <td class="td_l" colspan="1">{$v.totalUseTimeInThirtyDays}分钟</td>
         <td class="td_l" colspan="1">{$v.totalOperationCountInSevenDays}</td>
         <td class="td_l" colspan="1">{$v.totalOperationCountInThirtyDays}</td> -->
         <td class="td_l" colspan="1">{$v.todayUsingTime}分钟</td>
         <td class="td_l" colspan="1">{$v.todayOperationCount}</td>
  </tr>
      {/foreach}
    
     </tbody>
  </table>

