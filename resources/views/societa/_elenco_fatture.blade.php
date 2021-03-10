<tbody>
    @foreach ($fatture as $fattura)
    <form action="{{ route('fatture.destroy', $fattura->id) }}" method="post" id="delete_item_{{$fattura->id}}">
        @csrf
        @method('DELETE')
    </form>
    <tr>
        <th scope="row"><a href="{{ route('fatture.edit', $fattura->id) }}" title="Modifica fattura">{{$fattura->numero_fattura}}</a></th>
        <td> {{optional($fattura->data)->format('d/m/Y')}}</a></td>
        <td>{{optional($fattura->pagamento)->nome}}</td>
        <td>{{App\Utility::formatta_cifra($fattura->totale,'€')}}</td>
        <td>{!! $fattura->note!!}</td>
        <td>
            <a  data-id="{{$fattura->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>