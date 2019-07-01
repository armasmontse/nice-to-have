<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

use Image;
use Storage;

use App\User;
use App\Language;
use App\Photo;

use App\Models\Address\Country;
use App\Models\Address\Address;

use App\Models\Events\Type;
use App\Models\Events\EventStatus;
use App\Models\Events\EventTemplateHeader;
use App\Models\Events\EventTemplateSectionType;

use App\Models\Events\Event;
use App\Models\Events\EventTemplate;
use App\Models\Events\EventTemplateSection;

use Illuminate\Http\File;



class EventMarayFerSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Evento boda mara y fer";

    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return '';
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        $publish = EventStatus::getPublish();
        $user = User::where(['name'=> "mara-loera"])->first();
        $boda = $this->getTypeBoda();
        return [
            [
                "user_id"           => $user->id,
                "key"               => "bmayfe261116",
                "name"              => "MARA & FER",
                "slug"              => "mara-y-fer",
                "feted_names"       => "Mafer González y Roberto Mejía",
                "description"       => '<div class="event__address-container">
                    <p class="event__paragraph-bohemian">Hacienda San Pedro Ochil</p>
                    <p class="event__paragraph-bohemian">07 00 pm en punto</p>
                    <p class="event__paragraph-bohemian">Carretera Umán -Muná km. 175</p>
                    <p class="event__paragraph-bohemian">Mérida, Yucatán</p>
                </div>',
                "date"              => "2016-11-26 19:00:00",
                "timezone"          => "America/Mexico_City",
                "accept"            => true,
                "exclusive"         => true,
                "event_status_id"   => $publish->id,
                "typeable_id"       => $boda->id,
                "typeable_type"     => get_class($boda),

            ]
        ];
    }

    protected function getTypeBoda()
    {
        $boda = Type::GetObjectBySlug("boda");

        if (!$boda) {
            $boda = Type::create([
                "order" => null
            ]);

            $languages = Language::get();
            $boda_languages = [
                "es" => [
                    'label'         => "Boda",
                    'slug'          => "boda",
                    'title'         => '',
                    'description'   => '',
                ]
            ];

            foreach ($languages as $language) {
                if (isset($boda_languages[$language->iso6391])) {
                    $boda->updateTranslationByIso($language->iso6391,$boda_languages[$language->iso6391]);
                }
            }
        }

        return $boda;
    }

    /**
     * metodo de introduccion de valores
     * @param array   $model_args argumentos que definiran el
     * @param Command $comand     comando actual
     */
    protected function ClvoSetUp(array $model_args, Command $comand)
    {

        $marayfer = $this->getMaryFerEvent($model_args,$comand);

        if (!$marayfer) {
            return ;
        }

        $template = $this->getMaryFerTemplate($marayfer,$comand);

        if (!$template) {
            return ;
        }

        $this->setMarayFerAddress($marayfer, $comand);

        $this->setMaryFerTemplateSections($template,$comand);

    }

    protected function setMarayFerAddress(Event $marayfer, Command $comand)
    {

        if ($marayfer->addresses->count() > 0) {
            $comand->line('<comment>Mara y Fer event address:</comment>'." previously set.");
            return ;
        }

        $mexico = Country::getMexico();

        $address = Address::create([
            'contact_name'  => 'Mafer González',
            'phone'         => '(55) 12345678',
            'street1'       => 'Plaza Río de Janeiro 60BIS, Depto A',
            'street2'       => 'Col. Roma Norte',
            'street3'       => 'Del. Cuauhtémoc',
            'city'          => 'Cuidad de México' ,
            'state'         => 'Distrito Federal' ,
            'zip'           => '06700',
            "country_id"    => $mexico->id
        ]);

        if (!$address) {
            $comand->error('<error>Mara y Fer address:</error>'." not successfully set.");
            return;
        }

        if (!$marayfer->addresses()->save($address)) {
            $comand->error('<error>Mara y Fer event address:</error>'." not successfully set associate.");
            return;
        }

    }

    protected function getMaryFerEvent(array $model_args,Command $comand)
    {
        $marayfer = Event::where(["key"  =>$model_args["key"] ])->first();

        if (!$marayfer){
            $marayfer = Event::create($model_args);
            if ($marayfer) {
                $comand->line(  '<info>'.$model_args['name'].':</info>'." successfully set.");
            }else{
                $comand->error('<error>'.$model_args['name'].':</error>'." not successfully set.");
                return null;
            }
        }else {
            $comand->line('<comment>'.$model_args['name'].':</comment>'." previously set.");
        }

        return $marayfer;
    }

    protected function getTemplateArgs(Event $marayfer)
    {
        $template_header = EventTemplateHeader::where(["view"  => "media_imagen"])->first();

        return [
            'event_id'                      => $marayfer->id,
            'event_template_header_id'      => $template_header->id,
            'publish'                       => true,
            'timer'                         => true,
            'background_color'              => 'FFFFFF',
            'image_background_color'        => 'FFFFFF',
        ];
    }

    protected function getMaryFerTemplate(Event $marayfer,Command $comand)
    {
        $template = $marayfer->eventTemplate;

        if (!$template) {
            $template_args = $this->getTemplateArgs( $marayfer,$comand);
            $template = EventTemplate::create($template_args);
            if ($template) {
                $comand->line(  '<info>'.$marayfer->name.' template:</info>'." successfully set.");
            }else{
                $comand->error('<error>'.$marayfer->name.' template:</error>'." not successfully set.");
                return null;
            }

        }else{
            $comand->line('<comment>'.$marayfer->name.' template:</comment>'." previously set.");
        }
        $use_order_and_class = [ 'use' => "thumbnail" ];

        if (!$template->getFirstPhotoTo($use_order_and_class) ) {
            $image_path  = public_path()."/images/event/imagen_portada.png";
            $photo = $this->getPhotoTemplate($image_path, $template, $comand);

            if (!$photo){
                return null;
            }

            if ($template->associateImage($photo, $use_order_and_class)) {
                $comand->line(  '<info> '.$marayfer->name.' template photo:</info>'." successfully set.");
            }else{
                $comand->error('<error> '.$marayfer->name.' template photo:</error>'." not successfully set.");
                return null;
            }
        }else {
            $comand->line('<comment> '.$marayfer->name.' template photo:</comment>'." previously set.");
        }

        return $template;
    }

    protected function getPhotoTemplate($image_path,EventTemplate $template,Command $comand)
    {

        $origin_file = new File( $image_path);

        $file_path = Storage::putFile( Photo::STORAGE_PATH , $origin_file);

        if (!$file_path) {
            $comand->error('<error> photo file in template -> '.$template->event->name.':</error>'." not successfully save.");
            return null;
        }

        $photo = Photo::where([ 'filename'  => $file_path])->first();

        if ($photo) {
            $comand->line('<comment> photo in template -> '.$template->event->name.':</comment>'." previously set.");
        }else{
            try {
            // creamos el objeto de imagen
                $imageFile = Image::make( storage_path("app/".$file_path)  );

            // thunmbail
                $imageFile->resize(Photo::THUMBNAILS_SIZE, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            } catch (Exception $e) {
                $comand->error('<error> photo file in template -> '.$template->event->name.':</error>'." in not valid file.");
                Storage::delete($file_path);
                return null;
            }

            try {
                 $imageFile->save( Photo::getImagesThumbnailsPath()."/".$imageFile->basename );
            } catch (Exception $e) {
                $comand->error('<error> photo thumbnail file in template -> '.$template->event->name.':</error>'." not successfully save.");
                Storage::delete($file_path);
                return ;
            }

            $photo = Photo::create([
                'filename'  => $file_path,
                'type'      => $origin_file->getMimeType(),
            ]);
            if ($photo) {
                $comand->line(  '<info> photo in template -> '.$template->event->name.':</info>'." successfully set.");
            }else{
                $comand->error('<error> photo in template -> '.$template->event->name.':</error>'." not successfully set.");
                return null;
            }

            $languages = Language::get();


            foreach ($languages as $language) {
                $photo->updateTranslationByIso($language->iso6391,[
                    'title'          => "",
                    'alt'            => "",
                    'description'    => ""
                ]);
            }
        }

        return $photo;
    }

    protected function setMaryFerTemplateSections(EventTemplate $template, Command $comand)
    {
        $sections = $this->getMaryFerTemplateSections($template);
        foreach ($sections as $section_args) {
            $this->setSection($section_args,$comand);
        }
    }

    protected function setSection(array $section_args,Command $comand)
    {
        $section = EventTemplateSection::where(["order"  =>$section_args["order"] ])->first();

        $image_path = $section_args["photo"];
        unset($section_args["photo"]);

        if (!$section){
            $section = EventTemplateSection::create($section_args);
            if ($section) {
                $comand->line(  '<info> Section -> '.$section_args['order'].':</info>'." successfully set.");
            }else{
                $comand->error('<error> Section -> '.$section_args['order'].':</error>'." not successfully set.");
                return null;
            }
        }else {
            $comand->line('<comment> Section -> '.$section_args['order'].':</comment>'." previously set.");
        }

        if ($image_path) {
            $this->setPhotoSection($image_path, $section, $comand);
        }

    }

    protected function setPhotoSection($image_path,EventTemplateSection $section,Command $comand)
    {
        $use_order_and_class = [ 'use' => "thumbnail" ];


        if (!$section->getFirstPhotoTo($use_order_and_class) ){
            $photo = $this->getPhotoSection($image_path,$section,$comand);

            if (!$photo){
                return null;
            }
            if ($section->associateImage($photo, $use_order_and_class)) {
                $comand->line(  '<info> photo section -> '.$section->order.':</info>'." successfully set.");
            }else{
                $comand->error('<error> photo section -> '.$section->order.':</error>'." not successfully set.");
                return null;
            }

        }else {
            $comand->line('<comment> photo section -> '.$section->order.':</comment>'." previously set.");
        }

    }

    protected function getPhotoSection($image_path,EventTemplateSection $section,Command $comand)
    {

        $origin_file = new File( $image_path);

        $file_path = Storage::putFile( Photo::STORAGE_PATH , $origin_file);

        if (!$file_path) {
            $comand->error('<error> photo file in section -> '.$section->order.':</error>'." not successfully save.");
            return null;
        }

        $photo = Photo::where([ 'filename'  => $file_path])->first();

        if ($photo) {
            $comand->line('<comment> photo in section -> '.$section->order.':</comment>'." previously set.");
        }else{
            try {
            // creamos el objeto de imagen
                $imageFile = Image::make( storage_path("app/".$file_path)  );

            // thunmbail
                $imageFile->resize(Photo::THUMBNAILS_SIZE, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            } catch (Exception $e) {
                $comand->error('<error> photo file in section -> '.$section->order.':</error>'." in not valid file.");
                Storage::delete($file_path);
                return null;
            }

            try {
                 $imageFile->save( Photo::getImagesThumbnailsPath()."/".$imageFile->basename );
            } catch (Exception $e) {
                $comand->error('<error> photo thumbnail file in section -> '.$section->order.':</error>'." not successfully save.");
                Storage::delete($file_path);
                return ;
            }

            $photo = Photo::create([
                'filename'  => $file_path,
                'type'      => $origin_file->getMimeType(),
            ]);
            if ($photo) {
                $comand->line(  '<info> photo in section -> '.$section->order.':</info>'." successfully set.");
            }else{
                $comand->error('<error> photo in section -> '.$section->order.':</error>'." not successfully set.");
                return null;
            }

            $languages = Language::get();


            foreach ($languages as $language) {
                $photo->updateTranslationByIso($language->iso6391,[
                    'title'          => "",
                    'alt'            => "",
                    'description'    => ""
                ]);
            }
        }

        return $photo;
    }

    protected function getMaryFerTemplateSections(EventTemplate $template)
    {
        $types = EventTemplateSectionType::get()->keyBy('slug');
        return [
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 0,
                'publish'                           => true,
                'background_color'                  => "FFFDE5",
                'title'                             => "AGENDA",
                'html'                              => '<div class="event__diary-container">
                                                        	<h4>viernes 25 de noviembre de 2016</h4>
                                                            <p>
                                                                <b>12:00hrs a 17:30hrs</b>
                                                            </p>
                                                            <p>
                                                                <b>Están todos invitados a tomarse algo con los novios en la Hacienda Itzincab Cámara.</b>
                                                            </p>
                                                            <p>
                                                                (Itzincab Cámara, Tecoh, Yucatán) <br> Esta hacienda es parte del recorrido turístico de haciendas en Yucatán. <br> BYS (Bring your swimwear)<br><br>
                                                                * Pondremos transporte de ida y vuelta para que puedan llegar a Itzincab Cámara y regresar a Mérida sin problema. Los transportes saldrán cada hora a partir de las 15:00hrs del hotel Hyatt Regency Mérida y regresarán cada hora hasa las 02:00hrs de la Hacienda Itzincab Cámara.<br><br>
                                                                Los huéspedes hospedados en Sotuta de Peón y Temozón, también podrán contar con este transporte.
                                                            </p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>17:30hrs a 19:30hrs</b></p>
                                                            <p><b>Los novios tendrán una comida familiar.</b></p>
                                                            <p>Los invitados que estén en Itzincab Cámara y gusten comer algo cerca para después regresar, les recomendamos ir al restaurante del Hotel Sotuta de Peón (abierto de 17:00hrs a 21:00hrs) y ubicado a 5 minutos de la Hacienda Itzincab Cámara.</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>20:30hrs a 2:00hrs</b></p>
                                                            <p><b>Ceremonia civil en la Hacienda Itzincab Cámara.</b></p>
                                                            <p>(Itzincab Cámara, Tecoh, Yucatán) <br> Posteriormente habrá un cóctel informal para celebrar, todos los invitados que gusten acompañarnos en el civil son bienvenidos, no es petit comité, ni tampoco formal, no se preocupen por la vestimenta, lo importante es su compañía. Ofreceremos vino y cerveza.</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4>Sábado 26 de noviembre de 2016</h4>
                                                            <p><b>12:00hrs</b></p>
                                                            <p><b>Sesión de fotos casual en la Hacienda Itzincab Cámara.</b></p>
                                                            <p>(Itzincab Cámara, Tecoh, Yucatán) <br> Todos los que gusten acompañarnos en esta sesión son bienvenidos, la vestimenta es informal.</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>17:45hrs</b></p>
                                                            <p><b>Transporte a la boda</b></p>
                                                            <p>El transporte que llevará a los invitados hospedados en Mérida a la Hacienda San Pedro Ochil, lugar en donde se llevará a cabo la boda, saldrá del estacionamiento del Hotel Hyatt Regency Mérida (Av. Colón No.344 esq. Calle 60, Centro, Mérida, YUC) en el horario indicado. El servicio de transporte contará con distintos horarios para regresar por la noche.</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>19:00hrs (en punto)</b></p>
                                                            <p><b>Ceremonia de casamiento en el anfiteatro de la Hacienda San Pedro Ochil.</b></p>
                                                            <p>Posteriormente los invitamos a la cena y fiesta de celebración que se llevará a cabo en la misma hacienda hasta el amanecer (tomen sus precauciones pues queremos que todos lleguen hasta el final).</p>
                                                        	<p><br> Código de vestimenta: Cómodo para bailar <br><br> * Mujeres: recomendamos zapato plano o de plataforma pues la fiesta es en jardín. <br> * Hombres y Mujeres: En esta temporada la temperatura baja en las noches, recomendamos llevar algo caliente para taparse.</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>7:00hrs</b></p>
                                                            <p><b>Sesión de fotos al amanecer en las albercas de la Hacienda Itzincab Cámara</b></p>
                                                            <p>(Itzincab Cámara, Tecoh, Yucatán) <br> Quien guste acompañarnos, es bienvenido y les recomendamos llevar un cambio de ropa desde el principio para que puedan regresar secos a Mérida.</p>
                                                        </div>

                                                        <div class="event__diary-container">
                                                        	<h4>Domingo 27 de noviembre de 2016</h4>
                                                            <p><b>13:00hrs a 17:30hrs </b></p>
                                                            <p><b>Para recapitular las anécdotas del día anterior, están todos invitados a tomarse algo con los novios en la Hacienda Itzincab Cámara </b></p>
                                                            <p>(Itzincab Cámara, Tecoh, Yucatán). <br> BYS (Bring your swimwear)</p>
                                                        </div>
                                                        <div class="event__diary-container">
                                                        	<h4></h4>
                                                            <p><b>17:30hrs a 19:30hrs</b></p>
                                                            <p><b>Los novios tendrán una comida familiar.</b></p>
                                                            <p>Los invitados que estén en Itzincab Cámara y gusten comer algo cerca para después regresar, les recomendamos ir al restaurante del Hotel Sotuta de Peón (abierto de 17:00hrs a 21:00hrs) y ubicado a 5 minutos de la Hacienda Itzincab Cámara.</p>
                                                        </div>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ],// ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['imagen']->id,
                'order'                             => 1,
                'publish'                           => true,
                'background_color'                  => "FFFDE5",
                'title'                             => '',
                'html'                              => '',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => public_path().'/images/event/imagen_sello.png'
            ],
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['mapa']->id,
                'order'                             => 2,
                'publish'                           => true,
                'background_color'                  => "FFFFFF",
                'title'                             => 'MAPA DE LA CEREMONIA',
                'html'                              => '',
                'iframe'                             => '<iframe class="map_JS" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d955764.8391634948!2d-89.8697961!3d20.6510028!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f563f6cbd867ad9%3A0x72549ec4cc9bdd0d!2sHacienda+San+Pedro+Ochil!5e0!3m2!1sen!2smx!4v1477603885666" width="100%" height="310px" frameborder="0" style="border:0" allowfullscreen></iframe>',
                'link'                              => "https://goo.gl/maps/5xfcFheoe5R2",
                'content'                           => [],
                'photo'                             => false
            ], // ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 3,
                'publish'                           => true,
                'background_color'                  => "FFFDE5",
                'title'                             => '#AMORPIBIL',
                'html'                              => '<p>Ayúdanos a reunir todas las fotos del fin de semana con el hashtag #AmorPibil para que después podamos encontrarlas más fácil en internet.</p>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ], // ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['imagen']->id,
                'order'                             => 4,
                'publish'                           => true,
                'background_color'                  => "FFFFFF",
                'title'                             => '',
                'html'                              => '',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => public_path().'/images/event/imagen_flamingos.png'
            ],
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 5,
                'publish'                           => true,
                'background_color'                  => "FFFFFF",
                'title'                             => 'RECOMENDACIONES DE HOSPEDAJE',
                'html'                              => '<div class="event__recommendations-container">
                                                            <p><b>Hyatt Regency Mérida</b></p>
                                                            <p>(a 50 minutos de la boda y a 40 minutos de donde se hospedarán los novios)</p>
                                                            <p>merida.regency.hyatt.com/</p>
                                                            <p>Teléfonos: + (52)999-942-12-34 Ext. 3010, 3011 y 3005</p>
                                                            <p>Emails: rafael.bustos@hyatt.com / debbie.soberanis@hyatt.com / jessica.sanchez@hyatt.com</p>
                                                            <p>Clave para tarifa preferencial: G-MAFE ó Boda Mara y Fernando</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Presidente Intercontinental Mérida</b></p>
                                                            <p>(a 50 minutos de la boda y a 40 minutos de donde se hospedarán los novios)</p>
                                                            <p>www.presidenteicmerida.com/</p>
                                                            <p>Teléfonos: +(52)-999-9429000, 01800 2167628</p>
                                                            <p>Email: irving_valencia@grupopresidente.com</p>
                                                            <p>Clave para tarifa preferencial: Boda Mara y Fernando / Código de grupo W18</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Hotel Boutique Rosas & Chocolate</b></p>
                                                            <p>(a 50 minutos de la boda y a 40 minutos de donde se hospedarán los novios)</p>
                                                            <p>www.rosasandxocolate.com</p>
                                                            <p>Teléfono: + (52) 999- 9242992</p>
                                                            <p>Email: alicia@rosasandxocolate.com</p>
                                                            <p>Clave para tarifa preferencial: Boda Mara y Fernando</p>
                                                            <p>NOTA: Adicional se ofrecerá un 15% de descuento por persona para tratamientos de Spa de más de $900 pesos</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Hotel Boutique Casa Lecanda</b></p>
                                                            <p>(a 50 minutos de la boda y a 40 minutos de donde se hospedarán los novios)</p>
                                                            <p>www.casalecanda.com</p>
                                                            <p>Teléfono: + (52) 999- 9280112</p>
                                                            <p>Email: info@casalecanda.com</p>
                                                            <p>Clave para tarifa preferencial: MAFE1116</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Hotel Sotuta de Peón</b></p>
                                                            <p>(a 40 minutos de la boda y a 5 minutos de donde se hospedarán los novios, por lo tanto es una gran opción y también contará con transporte a la boda)</p>
                                                            <p>www.sotutadepeon.com/360.php</p>
                                                            <p>Teléfono: + (52) 999- 941 64 41</p>
                                                            <p>Email: reservas@haciendatour.com (Contacto: Belem Góngora)</p>
                                                            <p>Clave para tarifa preferencial: Boda MaFer</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <h5>Otras recomendaciones de hospedaje</h5>

                                                            <div>
                                                                <span><b>Fiesta Americana Mérida</b></span>
                                                                <a href="http://www.fiestamericana.com/es/home" target="_blank">www.fiestaamericana.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Casa de Balam</b></span>
                                                                <a href="http://www.casadelbalam.com/" target="_blank">www.casadebalam.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Hotel de Peregrino</b></span>
                                                                <a href="http://www.hoteldelperegrino.com/" target="_blank">www.hoteldeperegrino.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Casa Álvarez</b></span>
                                                                <a href="http://casaalvarezguesthouse.com/" target="_blank">www.casaalvarezguesthouse.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Posada Toledo</b></span>
                                                                <a href="http://www.posadatoledo.com/" target="_blank">www.posadatoldeo.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Casa Mexilio</b></span>
                                                                <a href="http://www.casamexilio.com/" target="_blank">www.casamexilio.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Hotel Medio Mundo</b></span>
                                                                <a href="http://hotelmediomundo.com/" target="_blank">www.hotelmediomundo.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Gran Hotel</b></span>
                                                                <a href="http://granhoteldemerida.com/mx/" target="_blank">www.granhotelmerida.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Hotel Caribe</b></span>
                                                                <a href="http://www.hotelcaribe.com.mx/" target="_blank">www.hotelcaribe.com.mx</a>
                                                            </div>

                                                            <div>
                                                                <span><b>La Mision de Fray Diego</b></span>
                                                                <a href="http://www.lamisiondefraydiego.com/" target="_blank">www.lamisiondefraydiego.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Hotel Hacienda Mérida</b></span>
                                                                <a href="https://www.hotelhaciendamerida.com/" target="_blank">www.hotelhaciendamerida.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Gran Real Yucatán</b></span>
                                                                <a href="http://www.granrealyucatan.com/" target="_blank">www.granrealyucatan.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Casa Azul Hotel</b></span>
                                                                <a href="http://www.casaazulhotel.com/" target="_blank">www.casaazulhotel.com</a>
                                                            </div>

                                                            <div>
                                                                <span><b>Airbnb</b></span>
                                                                <a href="https://www.airbnb.mx/" target="_blank">www.airbnb.mx</a>
                                                            </div>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Hacienda Temozón</b></p>
                                                            <p>(a 10 minutos de la boda y a 30 minutos de donde se hospedarán los novios)</p>
                                                            <p>www.theluxurycollection.com www.thehaciendas.com</p>
                                                            <p>Teléfono: + (52) 999 -924 73 01</p>
                                                            <p>Email: patricia.valdez@luxurycollection.com</p>
                                                            <p>
                                                                NOTA: En caso de hospedarse en Hacienda Temozón, favor de noti!car a los
                                                                novios al siguiente correo: amorpibil@gmail.com ya que en caso de que el hotel
                                                                cuente con 6 ó más habitaciones reservadas por parte de nuestros invitados, se
                                                                ofrecerá una tarifa preferencial.
                                                            </p>
                                                        </div>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ],//ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 6,
                'publish'                           => true,
                'background_color'                  => "FFFDE5",
                'title'                             => 'RECOMENDACIONES DE AEROLÍNEAS',
                'html'                              => '<p class="event__delimiter">
                                                            <a href="https://aeromexico.com/es/mx/" target="_blank"><b>Aeroméxico</b></a>
                                                        </p>

                                                        <p class="event__delimiter">
                                                            <a href="https://www.interjet.com.mx/" target="_blank"><b>Interjet</b></a>
                                                        </p>

                                                        <p class="event__delimiter">
                                                            <a href="https://www.volaris.com/" target="_blank"><b>Volaris</b></a>
                                                        </p>

                                                        <p class="event__delimiter">
                                                            <a href="https://www.vivaaerobus.com/mx" target="_blank"><b>Viva Aerobus</b></a>
                                                        </p>

                                                        <p>(la disponibilidad de horarios es amplia)</p> </br>
                                                        <p>Los que nos visitan del extranjero pueden volar a Cancún para tener un mejor precio.</p>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ],//ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 7,
                'publish'                           => true,
                'background_color'                  => "FFFFFF",
                'title'                             => 'SALONES DE BELLEZA',
                'html'                              => '<span><b>Josefina Herrera</b></span>
                                                        <span>9991-35-2137.</span>
                                                        <span><b>Paola Barroso</b></span>
                                                        <span>9999267818.</span> </br>
                                                        <span><b>Blanca Chi</b></span>
                                                        <span>999-9443507.</span>
                                                        <span><b>Maury Cervera</b></span>
                                                        <span>9991-226138.</span>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ],//ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['imagen']->id,
                'order'                             => 8,
                'publish'                           => true,
                'background_color'                  => "8CC7BB",
                'title'                             => '',
                'html'                              => '',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => public_path().'/images/event/imagen_patron.png'
            ],
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 9,
                'publish'                           => true,
                'background_color'                  => "FFFDE5",
                'title'                             => 'RECOMENDACIONES TURÍSTICAS',
                'html'                              => '<div class="event__recommendations-container">
                                                            <p><b>Celestún</b></p>
                                                            <p>En esta Reserva Natural se pueden observar grandes comunidades de flamingos.</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Izamal</b></p>
                                                            <p>Pintoresco pueblo amarillo que antiguamente fue un pueblo henequenero.</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Ruta de Haciendas</b></p>
                                                            <p>
                                                                Yucatán se reconoce por mantener antiguas haciendas henequeneras en perfecto estado,
                                                                algunas de las más reconocidas: Hacienda Yaxcopoil, Hacienda Temozón Sur,
                                                                Hacienda San Pedro Ochil, Hacienda Xcanatún, Hacienda Teya,
                                                                Hacienda Itzincab Cámara, Hacienda Chichén, Hacienda Misné, Hacienda Petac,
                                                                Hacienda Yokat, Hacienda Ticum, Hacienda Santa Cruz, Sotuta de Peón
                                                                (de las pocas que siguen produciendo henequen, cuenta con un tour)
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Chichén Itzá</b></p>
                                                            <p>Antiguas ruinas mayas</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Tour de Cenotes</b></p>
                                                            <p>A los alrededores de Mérida hay varios cenotes que se pueden visitar.</p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Mérida Centro</b></p>
                                                            <p>El Centro de la Ciudad de Mérida es hermoso y con mucho que visitar.</p>
                                                        </div>

                                                        <p>* Se recomienda rentar coche para visitar varios de los puntos anteriores.</p>
                                                    </div>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ], // ok
            [
                'event_template_id'                 => $template->id,
                'event_template_section_type_id'    => $types['texto']->id,
                'order'                             => 10,
                'publish'                           => true,
                'background_color'                  => "FFFFFF",
                'title'                             => 'RECOMENDACIONES GASTRONÓMICAS',
                'html'                              => '<div class="event__recommendations-container">
                                                            <p><b>Taquería Nuevo San Fernando.</b></p>
                                                            <p>
                                                                Ir temparano (cochinita y lechón).
                                                                Dirección: Av Cupules 503, Yucatán. Precio: $
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Helados El Colón.</b></p>
                                                            <p>
                                                                Perfecto para comprar un helado y seguir turisteando.
                                                                Dirección: Av. Paseo Montejo 474A, Merida. Precio: $
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Pizza Rafaello.</b></p>
                                                            <p>
                                                                Se dice ser la mejor pizza de todo Mérida (dueño italiano).
                                                                Dirección: Calle 60 No. 440A x 49 y 47, Centro, Mérida, Yucatán. Precio: $$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Cafetería Impala.</b></p>
                                                            <p>
                                                                Clásico Diner en versión yucateca (late dinner).
                                                                Dirección: Paseo de Montejo 497, Centro. Precio: $$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>La Pigua.</b></p>
                                                            <p>
                                                                 Perfecto para la cruda (mariscos).
                                                                 Dirección: Av. Cupules x Calle 62, Alcalá Martín, Mérida, Yucatán. Precio: $$$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Los Almendros.</b></p>
                                                            <p>
                                                                 Los originales (comida típica yucateca).
                                                                 Dirección: Parque de la Mejorada, Calle 50-A 493, Centro. Precio: $$$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>La Chaya Maya.</b></p>
                                                            <p>
                                                                Vale la pena esperar la fila (comida típica yucateca)
                                                                Dirección: Calle 55 No.510 x 60 y 62, Centro ó Calle 62 x 57, Centro Mérida (cualquiera de las dos sucursales). Precio: $$$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Mercado 60.</b></p>
                                                            <p>
                                                                Mercado hipster con música en vivo y distintas opciones de comida, perfecto para echar una copita de vino o una cerveza.
                                                                Dirección: Calle 60 461, Centro, Mérida. Precio: $$$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Rosas & Xocolate Hotel Boutique (restaurante).</b></p>
                                                            <p>
                                                                Perfecto para una cena formal (se recomienda reservar)
                                                                Dirección: Calle Paseo de Montejo 480, Centro. Precio: $$$$
                                                            </p>
                                                        </div>

                                                        <div class="event__recommendations-container">
                                                            <p><b>Casa Azul Hotel Boutique (restaurante).</b></p>
                                                            <p>
                                                                Perfecto para una cena formal (se recomienda reservar)
                                                                Dirección: Calle 60 #343 por 35 y 37, Centro. Precio: $$$$
                                                            </p>
                                                        </div>',
                'iframe'                            => '',
                'link'                              => '',
                'content'                           => [],
                'photo'                             => false
            ],
        ];
    }

}
