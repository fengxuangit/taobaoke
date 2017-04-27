
  <table class="tb tb2 nobdb">
     <tbody>

      <tr>
            <td colspan="3">{$start}-{$end}的版本使用情况</td>
        </tr>
     <tr class="noborder">
          <!-- <td class="td_l" colspan="1">时间</td> -->
          <td class="td_l" colspan="1">版本</td>
          <td class="td_l" colspan="1">累计用户</td>
          <td class="td_l" colspan="1">新注册用户数</td>
          <td class="td_l" colspan="1">新升级用户数</td>
          <td class="td_l" colspan="1">启动数</td>
         <!--  <td class="td_l" colspan="1">活跃用户数</td> -->
          <!-- <td class="td_l" colspan="1">应用累计使用时长</td> -->
        <!--   <td class="td_l" colspan="1">应用累计使用次数</td> -->
        </tr>
     
      {foreach from=$data item=v key=k}
       <tr>
        <!--  <td class="td_l" colspan="1">{$v.reportDate}</td> -->
         <td class="td_l" colspan="1">{$v.versionCode}</td>
         <td class="td_l" colspan="1">{$v.devicesCount}</td>
         <td class="td_l" colspan="1">{$v.newRegsCount}</td>
         <td class="td_l" colspan="1">{$v.newUpdateCount}</td>
         <td class="td_l" colspan="1">{$v.totalOperations}</td>
        <!--  <td class="td_l" colspan="1">{$v.activeCountInToday}</td> -->
         <!-- <td class="td_l" colspan="1">{$v.totalUseTime}</td> -->
         <!-- <td class="td_l" colspan="1">{$v.totalOperationCount}</td> -->

  </tr>
      {/foreach}
    
     </tbody>
  </table>

