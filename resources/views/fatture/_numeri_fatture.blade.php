<div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true" style="height: 400px; overflow: hidden;">
<table class="table table-striped m-table m-table--head-bg-success">
    <thead>
        <tr>
            <th>Data</th>
            <th>Tipo</th>
            <th>Numero</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($last_fatture as $f)
          <tr>
              <td>{{$f->data->format('d/m/Y')}}</td>
              <td>{{$f->tipo_id}}</td>
              <td>{{$f->numero_fattura}}</td>
          </tr>
        @endforeach
    </tbody>
</table>
</div>