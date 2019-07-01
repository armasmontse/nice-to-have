<table class="table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Nombre</th>
            <th>Roles</th>
            <th>Correo electrónico</th>
            <th class="text-center" >Editar</th>
            <th class="text-center" >Desactivar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        @foreach ($users as $user_edit)
            <tr class="">
                <td class="">
                    {{ $user_edit->first_name }} {{$user_edit->last_name }}
                </td>

                <td class="">
                    @forelse ($user_edit->roles as $role)
                        {{ $role->label }} <br>
                    @empty
                        <span>Sin rol</span>
                    @endforelse
                </td>

                <td class="">{{ $user_edit->email }}</td>

                <td class="text-center">

                    @if (!$user_edit->hasNoRoles())
                        <a href="{{ route( 'admin::users.edit', [$user_edit->id] ) }}" class="btn-link">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    @endif

                </td>


                <td class="text-center">


                    @if( $user_edit->id != $user->id )
                        {!! Form::open([
                            'method'             => 'delete',
                            'route'              => ['admin::users.destroy',$user_edit->id],
                            'role'               => 'form' ,
                            'id'                 => 'delete_user-'.$user_edit->id.'_form',
                            'class'              => 'form-inline'
                        ]) !!}

                            <button type="submit" class="btn-link " form ="delete_user-{{$user_edit->id}}_form">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        {{ Form::close() }}
                    @endif

                </td>

            </tr>
        @endforeach
    </tbody>
</table>
