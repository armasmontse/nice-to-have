<?php

use Illuminate\Database\Seeder;

use App\Language;
use App\Photo;

use App\Models\Address\Country;
use App\Models\Address\Address;

use App\Models\Events\Event;
use App\Models\Events\ColorPalette;
use App\Models\Events\EventTemplate;
use App\Models\Events\EventTemplateHeader;
use App\Models\Events\EventTemplateSection;
use App\Models\Events\EventTemplateSectionType;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $languages = Language::GetLanguagesIso()->toArray();

        factory(Event::class, 50)->create()->each( function($event) use ($languages, $faker){

            $mexico = Country::getMexico();

            $address = Address::create([
                'contact_name'  => explode(" ", $event->feted_names)[0] . " " . explode(" ", $event->feted_names)[1],
                'phone'         => $faker->phoneNumber,
                'street1'       => $faker->streetName . ', ' . $faker->secondaryAddress ,
                'street2'       => 'Col. ' . $faker->streetName,
                'street3'       => 'Del. ' . $faker->streetName,
                'city'          => $faker->city ,
                'state'         => $faker->state ,
                'zip'           => $faker->postcode,
                "country_id"    => $mexico->id
            ]);

            if (!$address) { return; }

            if (!$event->addresses()->save($address)) { return; }

            $template_header = EventTemplateHeader::get()->random(1);

            $color_palette = ColorPalette::get()->random(1);

            $template = EventTemplate::create([
                'event_id'                      => $event->id,
                'event_template_header_id'      => $template_header->id,
                'publish'                       => $event->is_draft ? 0 : rand(0, 1),
                'timer'                         => rand(0, 1),
                'background_color'              => $color_palette->colors->random(1),
                'image_background_color'        => $color_palette->colors->random(1),
                'color_palette_id'              => $color_palette->id,
            ]);

            if (!$template) { return null; }

            $use_order_and_class = [ 'use' => 'thumbnail' ];

            if (!$template->getFirstPhotoTo($use_order_and_class) ) {

                $photo = Photo::get()->random(1);

                if (!$photo){ return null; }

                if (!$template->associateImage($photo, $use_order_and_class)) { return null; }

            }

            $sections = $this->randomSections($template, $faker);

            foreach ($sections as $section_args) {

                $section = EventTemplateSection::where([ 'event_template_id' => $section_args['event_template_id'], 'order' => $section_args['order'] ])->first();

                $image_path = $section_args["photo"];

                unset($section_args["photo"]);

                if (!$section){

                    $section = EventTemplateSection::create($section_args);

                    if (!$section) { return null; }
                }

                if ($image_path) {

                    $use_order_and_class = [ 'use' => 'thumbnail' ];

                    if (!$section->getFirstPhotoTo($use_order_and_class) ){

                        $photo = Photo::get()->random(1);

                        if (!$photo){ return null; }

                        if (!$section->associateImage($photo, $use_order_and_class)) { return null; }

                    }

                }

            }

        });
    }

    protected function randomSections(EventTemplate $template, $faker)
    {
        $number_of_sections = rand(1, 10);
        $sections = [];

        for ($i=0; $i < $number_of_sections; $i++) {
            $sections[] = $this->generateRandomSection($template, $faker);
        }

        return $sections;
    }

    protected function generateRandomSection(EventTemplate $template, $faker)
    {
        $types = EventTemplateSectionType::get()->random(1);

        $order              = rand(0, 10);
        $publish            = rand(0, 1);
        $background_color   = rand(0, 1)                ? $template->colorPalette->colors->random(1) : '';
        $title              = $types->rules['title']    ? $faker->sentence : '';
        $html               = $types->rules['html']     ? '<div>' . $faker->text . '</div>' : '';
        $iframe             = $types->rules['iframe']   ? '<iframe class="map_JS" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d955764.8391634948!2d-89.8697961!3d20.6510028!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f563f6cbd867ad9%3A0x72549ec4cc9bdd0d!2sHacienda+San+Pedro+Ochil!5e0!3m2!1sen!2smx!4v1477603885666" width="100%" height="310px" frameborder="0" style="border:0" allowfullscreen></iframe>' : '';
        $link               = $types->rules['link']     ? $faker->url : '';
        $content            = $types->rules['content']  ? $faker->paragraphs : [];
        $photo              = $types->rules['photo']    ? true : false;

        return [
            'event_template_id'                 => $template->id,
            'event_template_section_type_id'    => $types->id,
            'order'                             => $order,
            'publish'                           => $publish,
            'background_color'                  => $background_color,
            'title'                             => $title,
            'html'                              => $html,
            'iframe'                            => $iframe,
            'link'                              => $link,
            'content'                           => $content,
            'photo'                             => $photo
        ];
    }

}
