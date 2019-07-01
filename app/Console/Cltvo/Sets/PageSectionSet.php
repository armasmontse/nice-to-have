<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

use App\Models\Pages\Sections\Section;
use App\Models\Pages\Sections\Type;

class PageSectionSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Secciones de páginas";

	/**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "index";



    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return Section::class;
    }

    /**
     * valores a ser introducidos en la base
     */

	protected function CltvoGetItems(){
        $types = Type::get();

        $fija = $types->where("protected",false)
            ->where("unlimited",false)
            ->where("sortable",false)
            ->first();
        $ilimitada = $types->where('protected', false)
            ->where('unlimited', true)
            ->where('sortable', true)
            ->first();
        return [
            [
                'index'             => 'home-action',
                'template_path'     => 'home.action',
                'components_max'    =>   3,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'thumbnail_img' => true,
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Imagen de fondo en el home. <br/> - Título y texto del recuadro blanco del lado izquierdo. <br/> - Título y texto del recuadro blanco del lado derecho.'
            ],
            [
                'index'             => 'us-intro',
                'template_path'     => 'us.intro',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'thumbnail_img' => true,
                    'content'       => true
                ],
                'description'       => '- Imagen de fondo en la parte superior de la sección Nosotros <br/> - Contenido del recuadro blanco que se encuentra al frente de la imagen de fondo.'
            ],
            [
                'index'             => 'us-steps',
                'template_path'     => 'us.steps',
                'components_max'    =>   3,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'gallery_img'   => true,
                    'title'         => true,
                    'subtitle'      => true,
                    'content'       => true
                ],
                'description'       => '- Título del paso. <br/> - Subtítulo (Paso 1, Paso 2 o Paso 3). <br/> - Instrucciones del paso. <br/> Galería de imágenes (únicamente funciona para el paso 1 y paso 2)'
            ],
            [
                'index'             => 'us-contact',
                'template_path'     => 'us.contact',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Título (Contáctanos). <br/> - Información de Contacto (Dirección, Teléfono, Horario, etc).'
            ],
            [
                'index'             => 'privacy_policy-content',
                'template_path'     => 'general.info',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Título principal(Aviso de Privacidad). <br/> - Contenido de aviso de privacidad'
            ],
            [
                'index'             => 'terms_and_conditions-content',
                'template_path'     => 'general.info',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Título principal (Términos y condiciones). <br/> - Contenido de los términos y condiciones.'
            ],
            [
                'index'             => 'faq-title',
                'template_path'     => 'faq.title',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true
                ],
                'description'       => '- Título principal(Preguntas frecuentes).'
            ],
            [
                'index'             => 'faq-gift_registery',
                'template_path'     => 'faq.info',
                'components_max'    =>   1,
                'type_id'           => $ilimitada->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => 'Pregunta. <br/> Respuesta.'
            ],
            [
                'index'             => 'faq-store',
                'template_path'     => 'faq.info',
                'components_max'    =>   1,
                'type_id'           => $ilimitada->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Pregunta. <br/> - Respuesta.'
            ],
            [
                'index'             => 'faq-purchases',
                'template_path'     => 'faq.info',
                'components_max'    =>   1,
                'type_id'           => $ilimitada->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Pregunta. <br/> - Respuesta.'
            ],
            [
                'index'             => 'faq-event',
                'template_path'     => 'faq.info',
                'components_max'    =>   1,
                'type_id'           => $ilimitada->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Pregunta. <br/> - Respuesta.'
            ],
            [
                'index'             => 'shipping_information-content',
                'template_path'     => 'general.info',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Título principal (Información de envío). <br/> - Contenido de información de envío.'
            ],
            [
                'index'             => 'commissions-content',
                'template_path'     => 'general.info',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true
                ],
                'description'       => '- Título principal(Comisiones). <br/> - Contenido de comisiones.'
            ],
            [
                'index'             => 'gift-card',
                'template_path'     => 'general.gift_card',
                'components_max'    =>   1,
                'type_id'           => $fija->id,
                'editable_contents' => [
                    'title'         => true,
                    'content'       => true,
                    'subtitle'      => true,
                    'thumbnail_img' => true
                ],
                'description'       => '- Título principal(Tarjeta impresa). <br/> -Subtítulo <br/> - Contenido acerca de las tarjetas impresas. <br/> -Imagen de una tarjeta impresa' 
            ]
        ];
    }

	/**
	 * metodo de introduccion de valores
	 * @param array   $model_args argumentos que definiran el
	 * @param Command $comand     comando actual
	 */
	protected function ClvoSetUp(array $model_args, Command $comand){

		$model_class = $this->CltvoGetModelClass();

		$args = $model_args;
		if(isset($args['translations']))
		{
			unset($args['translations']);
		}
		$model = $model_class::where(['index'	=>	$args['index']])->get()->first();

		if(!$model){
				$model = $model_class::create($model_args);
			if ($model) {
				try {
					$componets = $model->all_components;
				} catch (Exception $e) {
					$comand->error('<error>'.$model_args[$this->model_label].':</error>'." components not successfully set.");
				}
				$comand->line(  '<info>'.$model_args[$this->model_label].':</info>'." successfully set.");
			}else{
				$comand->error('<error>'.$model_args[$this->model_label].':</error>'." not successfully set.");
			}
		}else {
			$comand->line('<comment>'.$model_args[$this->model_label].':</comment>'." previously set.");
		}
	}

}
