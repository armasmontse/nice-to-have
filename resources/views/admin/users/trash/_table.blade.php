<table class="table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Nombre</th>
            <th>Roles</th>
            <th>Correo electrónico</th>
            <th class="text-center" >Reactivar</th>
        </tr>
    </thead>
    <tbody class="text__p">
        @foreach ($users_disabled as $user_disable)
            <tr class=" ">


                <td class="">
                    {{ $user_disable->first_name }} {{$user_disable->last_name }}
                </td>

                <td class="">
                    @forelse ($user_disable->roles as $role)
                        {{ $role->label }} <br>
                    @empty
                        <span>Sin rol</span>
                    @endforelse
                </td>

                <td class="">{{ $user_disable->email }}</td>

                <td class="text-center">

                        <div class="">
                            {!! Form::open([
                                'method'             => 'patch',
                                'route'              => ['admin::users.recovery',$user_disable->id],
                                'role'               => 'form' ,
                                'id'                 => 'recovery_user-'.$user_disable->id.'_form',
                            ]) !!}

                                <button type="submit" class="btn-link " form ="recovery_user-{{$user_disable->id}}_form">
                                    <i class="fa fa-repeat" aria-hidden="true"></i>
                                </button>

                            {{ Form::close() }}
                        </div>

                </td>


            </tr>
        @endforeach
    </tbody>
</table>
