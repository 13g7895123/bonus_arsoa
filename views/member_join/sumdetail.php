<div class="row">
     <div class="col-md-5">
          <table class="table text-right">
                          <thead>
                              <tr>
                              <th scope="col">&nbsp;</th>
                              <th scope="col">BP</th>
                              <th scope="col">建議售價</th>
                            </tr>
                            </thead>
                          <tbody>
                              <tr>
                              <th scope="row">A類</th>
                              <td><?=number_format($sumdetail['a_pv'])?></td>
                              <td><?=number_format($sumdetail['a_amt'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">B類</th>
                              <td><?=number_format($sumdetail['b_pv'])?></td>
                              <td><?=number_format($sumdetail['b_amt'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">合計</th>
                              <td><?=number_format($sumdetail['pv'])?></td>
                              <td><?=number_format($sumdetail['u_amt'])?></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                      <div class="col-md-4">
                          <table class="table text-right">
                          <thead>
                              <tr>
                              <th colspan="2" scope="col">紅利點數</th>
                            </tr>
                            </thead>
                          <tbody>                            
                              <tr>
                              <th scope="row">+ 回饋紅利</th>
                              <td><?=number_format($sumdetail['r_mp'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">+ 加贈紅利</th>
                              <td><?=number_format($sumdetail['p_mp'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">- 兌換紅利</th>
                              <td><?=number_format($sumdetail['m_mp'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">= 目前結餘</th>
                              <td><?=number_format($sumdetail['mp'])?></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                      <div class="col-md-3">
                          <table class="table text-right">
                          <thead>
                              <tr>
                              <th colspan="2" scope="col">交易金額</th>
                            </tr>
                            </thead>
                          <tbody>
                              <tr>
                              <th scope="row">合計</th>
                              <td><?=number_format($sumdetail['amt'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">運費</th>
                              <td><?=number_format($sumdetail['freight'])?></td>
                            </tr>
                              <tr>
                              <th scope="row">總金額</th>
                              <td><?=number_format($sumdetail['amt'])?></td>
                            </tr>
              </tbody>
         </table>
   </div>
</div>