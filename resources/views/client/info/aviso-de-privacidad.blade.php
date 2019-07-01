@extends('layouts.client')

@section('title')
    | Aviso de privacidad
@endsection

@section('content')
    <?php $content =
        '<h2>
            De conformidad con lo dispuesto por los artículos 15, 16, 17, 22, 23, 24, 25, 28, 29, 36 y demás relativos y aplicables de La Ley Federal de Protección de Datos Personales en Posesión de Particulares y su Reglamento, <b>NTH DE DISEÑO S.A. DE C.V.</b> con nombre comercial <b>NICE TO HAVE</b> declara ser una empresa mexicana con domicilio en Amatlán 37, Piso 3, Interior 3, Colonia Cuauhtémoc, C.P. 06140, México, D.F., y que es responsable de recabar sus datos personales, del uso que se le dé a los mismos y de su protección, haciendo de su conocimiento lo siguiente:
        </h2><br><br>
        <ol class="lower-alpha">
            <li>
                La finalidad del tratamiento de datos es prestar a los <b>DESTINATARIOS</b> o <b>USUARIOS</b> el servicio solicitado en <b>NTH DE DISEÑO S.A. DE C.V.</b> y para ello requerimos información de los <b>USUARIOS</b> o <b>DESTINATARIOS</b> y los datos de quien(es) utilicen la página de <b>NTH DE DISEÑO S.A. DE C.V.</b> <a href="'.route('client::pages.index').'">(www.nicetohave.com.mx)</a> para compra de regalos, ya sea con motivo de un <b>EVENTO</b> o para uso personal.
            </li>
            <li>
                Para la finalidad antes mencionada, podremos requerirle los siguientes datos personales : <br><br>
                <ul>
                    <li> Nombre completo </li>
                    <li> Fecha de nacimiento y edad </li>
                    <li> Sexo </li>
                    <li> Estado Civil </li>
                    <li> Datos de la cuenta bancaria que utilizará </li>
                    <li> Datos financieros </li>
                    <li> Teléfono fijo y/o celular </li>
                    <li> Correo electrónico </li>
                    <li> Firma autógrafa </li>
                    <li> Domicilio particular, trabajo, o aquel en el que recibe sus estados de cuenta. </li>
                    <li> RFC y/o CURP </li>
                    <li> Identificación oficial válida (pasaporte vigente, credencial para votar, cédula profesional, cartilla del Servicio Militar Nacional, otra identificación oficial vigente con fotografía y firma, expedida por el gobierno federal, estatal, municipal o del Distrito Federal, el documento migratorio vigente que corresponda (extranjeros)). </li>
                </ul>
            </li>
            <li>
                Sus datos personales serán resguardados bajo medidas de seguridad administrativas, técnicas y físicas, las cuales han sido implementadas con el objeto de proteger sus datos personales contra daño, pérdida, alteración, destrucción o el uso, acceso o tratamiento no autorizados.
            </li>
            <li>
                Los titulares podrán limitar el uso o divulgación de sus datos en cualquier momento mediante aviso por escrito o correo electrónico y con acuse de recibo dirigido al correo <a href="mailto:contacto@nicetohave.com.mx">contacto@nicetohave.com.mx</a>
            </li>
            <li>
                De igual forma y por el mismo medio escrito o correo electrónico con acuse de recibo, podrán ejercer los derechos de acceso, rectificación, cancelación u oposición de conformidad con lo dispuesto en la Ley de la materia.
            </li>
            <li>
                <b>NTH DE DISEÑO S.A. DE C.V.</b> con fundamento en La Ley Federal de Protección de Datos Personales en Posesión de Particulares, podrá hacer la transferencia de datos a que se refiere el contrato firmado con los <b>DESTINATARIOS</b> y además queda autorizada por el titular a transferir los datos que requiera el Banco o Institución de Crédito respecto a la identidad y forma de pago con la que el o los USUARIO(S) paga(n) su(s) regalo(s), a fin de lograr para <b>NTH DE DISEÑO S.A. DE C.V.</b> la autorización Bancaria correspondiente a la transacción solicitada por internet; igualmente queda autorizada a transferir los datos del o los USUARIO(S) a los <b>DESTINATARIOS</b> a fin de que éstos últimos sepan quién(es) le(s) hicieron el regalo con motivo de su <b>EVENTO</b> y demás detalles de la transacción.
            </li>
            <li>
                <b>NTH DE DISEÑO S.A. DE C.V.</b> comunicará por este medio electrónico a los titulares de los datos personales de cambios al Aviso de Privacidad, de conformidad con lo previsto en la Ley.
            </li>
            <li>
                <b>NTH DE DISEÑO S.A. DE C.V.</b>, tratará y resguardará sus datos personales con base en los principios de licitud, calidad, consentimiento, información, finalidad, lealtad, proporcionalidad y responsabilidad consagrados en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y su Reglamento.
            </li>
            <li>
                Los titulares de la información o datos personales después de dar la información que se les solicita y continuar su proceso de navegación dentro de la página de internet www.nicetohave.com.mx manifiestan con ello tácitamente estar de acuerdo:<br><br>
                <ol class="lower-alpha">
                    <li>
                        En los términos y condiciones de este Aviso de Privacidad
                    </li>
                    <li>
                        Que <b>NTH DE DISEÑO S.A. DE C.V.</b> les envíe por medios electrónicos comunicaciones que considere que sean o serán de su interés relacionadas con la(s) operación(es) que van a realizar o relacionadas con el giro económico y comercial de ésta.
                    </li>
                </ol>
            </li>
        </ol>';
    ?>
    @include('client.general.general-page', ['title' => 'Aviso de Privacidad',  'content' => $content])
@endsection
