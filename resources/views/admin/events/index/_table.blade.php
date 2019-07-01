<table class="table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>ID</th>
            <th>Nombre del evento</th>
            <th>Tipo de evento</th>
            <th>Usuario</th>
            <th>Exclusividad</th>
            <th>Tipo de evento</th>
            <th>Estatus</th>
            <th>Fecha del evento</th>
            <th># de carritos</th>
            <th class="text-center" >Detalles</th>
        </tr>
    </thead>

    <tbody class="text__p">
        @foreach ($events as $event)
            <tr class="">
                <td>
                    {{ $event->key }}
                </td>
                <td>
                    {{ $event->name }}
                </td>
                <td>
                    {{ $event->type }}
                    @if (isset($event->typeable->type))
                        <strong>Tipo de evento:</strong> {{ $event->typeable->type->label }}
                    @endif
                    @if (isset($event->typeable->type))
                        <strong>Variación de evento:</strong>
                    @else
                        <strong>Tipo:</strong>
                    @endif
                    {{ $event->typeable->label }}
                </td>
                <td>
                    {{ $event->user->full_name }}
                </td>
                <td>
                    @if ($event->exclusive)
                        Mesa de regalos única
                    @else
                        Tengo más mesas de regalos
                    @endif
                </td>
                <td>
                    {{ $event->typeable->label }}
                </td>
                <td>
                    {{ $event->eventStatus->label }}
                </td>
                <td>
                    {{ $event->date }}
                </td>
                <td>
                    {{ $event->getBagsCount() }}
                </td>
                <td class="text-center">
                    <a href="{{ route('admin::events.show', $event) }}" class="icon">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
