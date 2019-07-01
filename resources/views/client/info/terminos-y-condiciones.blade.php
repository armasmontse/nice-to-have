@extends('layouts.client')

@section('title')
    | Términos y condiciones
@endsection

@section('content')
    <?php $content =
                '<h1>CLÁUSULAS</h1></br></br>
                <h2>PRIMERA. OBJETO Y OPERACIÓN</h2>
                <p>El prestador se obliga a prestar al cliente y el cliente esta de acuerdo en recibir del prestador los servicios de administración de mesa de regalos electrónica a través de la página de internet <b>www.nicetohave.com.mx</b> que consiste en ofrecer un catálogo de los productos y servicios relacionados con el evento a realizarse.</p>
                <h3>OPERACIÓN</h3></br>
                <p>La operación del sitio web es la siguiente:</p>
                <ol>
                    <li>El “cliente” se dará de alta por medio de la página web <a href="'.route('client::pages.index').'">www.nicetohave.com.mx</a> creando un usuario y contraseña para posteriormente crear su evento o en su defecto, comprar uno o varios productos.</li>
                    <li>En la página existe un catálogo de productos y/o servicios de los establecimientos y proveedores afiliados al “prestador”.</li>
                    <li>En el caso de requerir una mesa de regalos, el “prestador” dará de alta una cuenta bancaria a favor del “cliente” a efecto de que los usuarios de la página web nicetohave.com.mx puedan transferir al prestador, a través de los medios de pago habilitados en la página web para tal efecto y de acuerdo con los términos y condiciones estipulados, una cantidad de dinero equivalente al precio de los productos o servicios de la mesa de regalos (los "fondos").</li>
                    <li>Una vez recibidos los fondos por el prestador, éste se obliga a transferirlos al cliente en los plazos y los términos previstos en Ia cláusula segunda y cuarta del presente contrato (los "servicios").</li>
                </ol>

                <h2>SEGUNDA. CONDICIONES DE LA MESA DE REGALOS</h2>
                <p>
                    El “cliente” escogerá entre las opciones “MESA DE REGALOS ÚNICA” ó “MESA DE REGALOS COMPARTIDA” y acepta que dependiendo su selección, se le cobrará la comisión correspondiente al momento de transferir los “fondos” a su cuenta.</br></br>
                    Comisiones:</br></br>
                    MESA DE REGALOS ÚNICA: 5% sobre el total de los fondos transferidos a la cuenta bancaria del cliente.</br></br>
                    En esta opción, el “cliente” acepta que no podrá incluir dentro de su evento e invitación, ninguna otra mesa de regalos.</br></br>
                    MESA DE REGALOS COMPARTIDA: 7% sobre el total de los fondos transferidos a la cuenta bancaria del cliente.</br></br>
                    Las comisión se cobrará en cada transferencia y el “cliente” tendrá derecho a 2 transferencias antes de la fecha de vigencia de la mesa de regalos.</br></br>
                    El “cliente” acepta que del total de “los fondos” recibidos por el “prestador” hasta un 70% podrá ser entregado a través de transferencias bancarias a la cuenta indicada por el “cliente” y después de la comisión (7% o 5% dependiendo el caso) y un mínimo del 30% será entregado en productos del “catálogo” de la página web nicetohave.com.mx, mismos que serán previamente seleccionados por “el cliente” antes de la fecha estipulada en la carátula del evento.</br></br>
                    El costo de envío de los productos seleccionados, será cobrado al “cliente” una vez que los productos seleccionados pasen al carrito de compras, previo al pago de los mismos.</br></br>
                    El “cliente” acepta que no hay devoluciones en ningún tipo de producto o experiencia y acepta también que en caso de requerir algún cambio, deberá revisarlo directo con el proveedor.</br></br>
                    El “cliente” acepta que el “prestador” no es responsable de ninguno de los tiempos de entrega de los proveedores.
                </p>

                <h2>TERCERA. VIGENCIA</h2>
                <p>
                    El presente contrato entrará en vigor a partir de la fecha de firma del mismo y permanecerá vigente hasta tres meses posteriores a la fecha del evento estipulada en la carátula del presente contrato (la "vigencia").</br></br>
                    El cliente podrá dar por terminado anticipadamente el presente contrato en cualquier momento, con previa notificación por escrito al correo electrónico del prestador, mismo que se especifica en la carátula del presente contrato y con 15 días hábiles de anticipación a la fecha en que el cliente desée darlo por terminado (la "Terminación Anticipada"). En este caso el “prestador” devolverá al cliente el 100% del valor de los “fondos” (una vez aplicada la contraprestación a la que se refiere la cláusula segunda del presente contrato) recibidos a la fecha de la terminación anticipada.
                </p>

                <h2>CUARTA .TRANSFERENCIA DE LOS FONDOS</h2>
                <p>
                    El “cliente” tiene derecho a solicitar dos transferencias bancarias de sus fondos.</br></br>
                    Una vez que el “cliente” decida recibir una transferencia bancaria de sus “fondos”, deberá enviar un aviso por correo electrónico a contacto@nicetohave.com.mx con 5 días hábiles de anticipación.</br></br>
                    El monto de los “fondos” a transferir será hasta el 70% del acumulado de los mismos (después del 5% o 7% de comisión) a la fecha de recepción de la solicitud vía correo electrónico y confirmada por el “prestador” de la “disposición” en cuestión. El 30% de los fondos de esta primera “disposición” serán entregados en producto al finalizar la mesa de regalos según la fecha de vigencia estipulada en la carátula del evento.</br></br>
                    La segunda y última disposición será posterior a la fecha del evento y previa a la terminación del mismo contemplando la vigencia estipulada en la carátula del evento junto con el remanente de los fondos recibidos por el prestador y bajo las condiciones indicadas en la cláusula segunda del presente contrato.</br></br>
                    Si el “cliente” no realizara sus disposiciones dentro de la vigencia estipulada, está de acuerdo en que “el prestador” entregará el total de los “fondos” recibidos en una sola transferencia bancaria (menos la comisión del 5% o 7%).
                </p>

                <h2>QUINTA. TERMINOS DE LOS SERVICIOS</h2>
                <p>
                    En el caso de MESAS DE REGALOS el “cliente” reconoce y está de acuerdo en que los productos y/o servicios contenidos en el catálogo de nicetohave.com.mx son únicamente una referencia para que los usuarios de la página puedan determinar un monto a transferir al prestador. En virtud de lo anterior, los productos y/o servicios descritos en el catálogo de nicetohave.com.mx no podrán ser considerados una oferta de venta por parte del prestador, ni el precio publicado de los mismos podrá ser considerado como un precio de venta. Por esta razón, los productos comprados en MESAS DE REGALOS, no podrán ser facturados al cliente.</br></br>
                    En el caso de MESA DE REGALOS y TIENDA ONLINE, el “prestador” no garantiza ni asume ninguna responsabilidad de que los establecimientos y proveedores afiliados cuenten con los productos y/o servicios ofrecidos en el catálogo de nicetohave.com.mx ni que el precio de los mismos sea aquel publicado al momento de la selección de los mismos por parte del cliente.
                </p>

                <h2>SEXTA. DERECHOS DE AUTOR Y PROPIEDAD INTELECTUAL</h2>
                <p>
                    El “cliente” reconoce y acepta que todo el material impreso, audiovisual o cualquier clase de material que utilice el “prestador” o proporcione al “cliente” para el cumplimiento del presente contrato es propiedad del prestador por lo que se obliga a no utilizarlo sin su consentimiento por escrito y no intentar replicarlo o afectar de alguna forma sus derechos de autor y de propiedad intelectual.
                </p>

                <h2>SÉPTIMA. PRIVACIDAD</h2>
                <p>
                    El “prestador” se obliga a tratar y utilizar los datos personales del cliente, incluyendo los sensibles que actualmente o en el futuro obtenga en virtud del presente contrato, en términos de lo dispuesto por la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (la "LFPDPPP") y se obliga a no utilizarlos ni transmitirlos a terceros sin el consentimiento previo del cliente excepto cuando por la naturaleza de los servicios se requieran transmitir a efecto de estar en posibilidad de prestarlos. </br>
                    Para más información, ver <a href="'.route("client::pages.show","aviso-de-privacidad").'">AVISO DE PRIVACIDAD.</a>
                </p>

                <h2>OCTAVA. CASO FORTUITO O FUERZA MAYOR</h2>
                <p>
                    El incumplimiento a los términos y condiciones de este contrato, originado por caso fortuito o fuerza mayor, no será causa de responsabilidad contractual para ninguna de las partes, y ambas tendrán derecho a suspender las obligaciones contenidas en este contrato, previa notificación por escrito a la otra parte, dentro de un término no mayor a treinta días hábiles contados a partir de que se tenga conocimiento de tal circunstancia.
                </p>

                <h2>NOVENA. CESIÓN DE DERECHOS</h2>
                <p>
                    Ambas partes convienen en que ninguna podrá ceder, traspasar o modificar total o parcialmente los derechos y obligaciones derivadas del presente contrato, salvo pacto o convenio por escrito, debidamente firmado por ambas partes.
                </p>

                <h2>DÉCIMA. AVISOS Y NOTIFICACIONES</h2>
                <p>
                    Todos los avisos y notificaciones que las partes deban darse en relación con este contrato, deberán hacerse por correo electrónico a <a href="mailto:contacto@nicetohave.com.mx">contacto@nicetohave.com.mx</a>.
                </p>

                <h2>DÉCIMA PRIMERA. IMPUESTOS</h2>
                <p>
                    Cada una de las partes será, en su caso, responsable de pagar los impuestos, cargas y demás contribuciones que a su cargo se generen por el cumplimiento del presente contrato.
                </p>

                <h2>DÉCIMA SEGUNDA. LEYES APLICABLES Y JURISDICCIÓN</h2>
                <p>
                    Para la interpretación y cumplimiento de este contrato, las partes se someten expresamente a las leyes aplicables y al fuero de los tribunales competentes en la Ciudad de México, renunciando a otra legislación y al fuero que pudiera corresponderles por razón de sus domicilios presentes o futuros o por cualquier otra causa.
                </p>

                <p>
                    Al hacer click en “Acepto términos y condiciones”, el “cliente” acepta todas las cláusulas anteriormente descritas.
                </p>'
    ?>
    @include('client.general.general-page', ['title' => 'Términos y condiciones',  'content' => $content])
@endsection
