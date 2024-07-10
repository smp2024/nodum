@foreach ($cats as $cat)
<table class="table">
    <thead>
        <tr>
            <td >Nombre</td>
            <td  width="50">Estado</td>
            <td width="150"></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($cats as $cat)
            <tr>
                <td>{{$cat->icono}}</td>
                <td>{{ $cat->name }}</td>
                <td class="text-center">
                    @if ($cat->status == '1')
                        <i class="fas fa-globe-americas" style="color: green;"></i>
                    @else
                        <i class="fas fa-globe-americas" style="color: red;"></i>
                    @endif
                </td>                                            <td>
                    <div class="opts">
                        @if (kvfj(Auth::user()->permissions, 'tag_edit'))
                            <a href="{{ url('/admin/tag/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                <i class="fas fa-edit" style="color: #ffc107;"></i>
                            </a>
                        @endif
                        @if (kvfj(Auth::user()->permissions, 'tag_delete'))

                            <a href="#" data-action="delete" data-path="/admin/tag" data-object="{{ $cat->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
                                <i class="fas fa-trash-alt" style="color: red;"></i>
                            </a>

                        @endif
                    </div>
                </td>

            </tr>

        @endforeach
    </tbody>
</table>

    </div>

@endforeach
