<table class="dataTable_JS table">

    <thead class="text__p text__p-table-head">
        <tr>
            <th>Evento</th>
            <th>Retiro de efectivo</th>
            <th>Comisión por retiro</th>
            <th>Total de transferencia</th>
            <th>Estatus de transferencia</th>
            <th>Información bancaria</th>
            <th>Fecha de solicitud</th>
        </tr>
    </thead>

    <tbody class="text__p">
        <tr v-for="cashout in list">
            <td>
                @{{ cashout.event.name }} <br>
                (#@{{ cashout.event.key | uppercase }})
            </td>
            <td>
                @{{ cashout.total | currency }}
            </td>
            <td>
                @{{ cashout.fee_value | currency }} <br>
                (@{{ cashout.fee }}%)
            </td>
            <td>
                @{{ cashout.total_out | currency}}
            </td>
            <td>
                @{{ cashout.cash_out_status.label }} <br>
                <a href="#" data-toggle="modal" data-target="#cashout-status-edit" data-index="@{{$index}}">
                    (Cambiar estatus)
                </a>
            </td>
            <td>
                Nombre: @{{ cashout.bank_account.name }} <br>
                Banco: @{{ cashout.bank_account.bank }} <br>
                Sucursal: @{{ cashout.bank_account.branch }} <br>
                CLABE: @{{ cashout.bank_account.CLABE }} <br>
                Número de cuenta: @{{ cashout.bank_account.account_number }} <br>
            </td>
            <td>
                @{{ cashout.created_at }}
            </td>
        </tr>
    </tbody>

</table>
