<thead>
    <tr>
      <th>N.fattura</th>
      <th class="order" data-orderby="data" @if (\Request::get('orderby') == 'data' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
          Data 
          @if (\Request::get('orderby') == 'data') 
              @if (\Request::get('order') == 'asc')
                  <i class="fa fa-sort-numeric-down"></i>
              @else 
                  <i class="fa fa-sort-numeric-up"></i> 
              @endif
          @endif
      </th>
      <th class="order" data-orderby="pagamento_id" @if (\Request::get('orderby') == 'pagamento_id' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
          Pagamento 
          @if (\Request::get('orderby') == 'pagamento_id') 
              @if (\Request::get('order') == 'asc')
                  <i class="fa fa-sort-alpha-down"></i>
              @else 
                  <i class="fa fa-sort-alpha-up"></i> 
              @endif
          @endif
      </th>
      <th>Totale</th>
      <th>Note</th>
      <th></th>
    </tr>
</thead>