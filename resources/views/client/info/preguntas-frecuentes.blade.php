@extends('layouts.client')

@section('title')
	| Preguntas frecuentes
@endsection

@section('content')

	@include('client.general.page-title', ['title'=> 'preguntas frecuentes'])

		<div class="general-page-info-section faq_section_JS">
			<div class="general-page-info-section__container grid__container">
				<div class="grid__col-1-1--sm">
					<h3 class="general-page-info-section__ttl faq_btn_JS">Tienda
						<span class="general-page-info-section__caret faq_caret_JS">
							{!! file_get_contents('images/flecha-faq.svg') !!}
						</span>
					</h3>
				</div>
			</div>
			<div class="divisor"></div>
			<div class="faq_children-container_JS" style="display:none">
				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿PUEDO RECIBIR DINERO EN EFECTIVO COMO PARTE DE MIS REGALOS?</h3>
							<p class="general-page-info-section__p">
								Claro, de la suma total que recibas por parte de tus invitados, hasta el 70% lo puedes recibir vía una transferencia bancaria y mínimo el 30% lo tendrás que retirar en productos de la tienda online.
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿CUÁNTO TIEMPO TENGO PARA ESCOGER MIS REGALOS Y RECIBIR MI DINERO VÍA TRANSFERENCIA?</h3>
							<p class="general-page-info-section__p">
								Cuentas con tres meses a partir de la fecha de tu evento, es decir, si tu evento fue el 26 de noviembre de 2016, tendrás como fecha límite para escoger tus regalos y recibir tu dinero vía transferencia el 26 de febrero de 2016.
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿DE LOS REGALOS QUE DECIDA QUEDARME, TENGO QUE ESCOGER DE LOS QUE MIS INVITADOS ME REGALARON?</h3>
							<p class="general-page-info-section__p">
								No necesariamente, podrás escoger los regalos que tú quieras siempre y cuando sean de nuestra tienda en línea y cumplas con el mínimo a retirar en producto (30%).
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿PUEDO RECIBIR PARTE DE MI DINERO ANTES DE LA FECHA DE MI EVENTO?</h3>
							<p class="general-page-info-section__p">
								Sí, puedes realizar dos transferencias bancarias durante la vigencia de tu mesa de regalos y tú decides cuándo, sólo tienes que avisar vía correo electrónico con 5 días hábiles de anticipación. </br></br>
								Recuerda que sólo podrás retirar hasta el 70% del dinero acumulado hasta el momento.
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿CUÁL ES LA DIFERENCIA ENTRE ESCOGER "MESA DE REGALOS ÚNICA" Ó "MESA DE REGALOS COMPARTIDA"?</h3>
							<p class="general-page-info-section__p">
								La diferencia es la comisión que NICE TO HAVE te cobrará por administrar tu dinero. Si escoges la opción de “MESA DE REGALOS ÚNICA”, la comisión será del 5%, pero si escoges la opción de “MESA DE REGALOS COMPARTIDA”, la comisión será del 7%.</br></br>
								Te recordamos que en la opción de “MESA DE REGALOS ÚNICA”, no puedes poner ningún otro tipo de mesa de regalos en tu evento e invitación, de lo contrario, se te cobrará el 7% de comisión.
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿CÓMO PUEDO TENER EL CONTROL DE TODO LO QUE ME HAN REGALADO MIS INVITADOS?</h3>
							<p class="general-page-info-section__p">
								Para crear un evento, te pediremos crear una cuenta, dentro de la cual podrás ver qué te ha regalado cada persona y el mensaje de felicitación que te dejaron.</br></br>
								De cualquier manera, también recibirás un correo electrónico cada vez que alguien te haga un regalo.
							</p>
						</div>
					</div>
				</div>

				<div class="general-page-info-section">
					<div class="general-page-info-section__container grid__container">
						<div class="grid__col-1-1--sm">
							<h3 class="general-page-info-section__ttl">¿PUEDO CREAR UN EVENTO QUE NO SEA UNA BODA?</h3>
							<p class="general-page-info-section__p">
								Claro, en NICE TO HAVE puedes crear el evento que quieras, bodas, aniversarios, despedidas de cualquier tipo, cumpleaños, open house, fiestas infantiles, baby showers, bautizos, Brit Milá ó cualquier evento que quieras festejar.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection
