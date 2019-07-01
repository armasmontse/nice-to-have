<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

use File;

class CountrySet
{

    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "";
    }

    /**
     * Etiqueta a desplegarse par ainformar final
     */
    public function CltvoGetLabel(){
        return "Countries";
    }

    /**
     * corre el cicolara salvar cada uno de los valores en la base
     */
    public function CltvoSet(Command $comand){

        $seeder_folder = storage_path("app/cltvo/country_seeder") ;

        if (!File::exists($seeder_folder)) {
            File::makeDirectory($seeder_folder);
        }

        $seeder_file = storage_path('app/cltvo/country_seeder/countries.csv');

        if (File::exists($seeder_file)) {

            $countries = $this->getCountriesArrayFromCSV($seeder_file);
            $languages = \App\Language::GetLanguagesIso()->toArray();

            foreach ($countries as $data_country) {

                $country_exist = \App\Models\Address\Country::where('iso3166', $data_country['iso3166'] )->get()->first();

                if (!$country_exist) {

                    $country = new \App\Models\Address\Country;
                    $country->iso3166 = $data_country['iso3166'];

                    if (!$country->save()) {
                        $comand->comment("<error>The country ".$data_country['es']."</error> not successfully set.");
                    }

                    foreach ($languages as $id => $iso) {

                        $country->updateTranslationByIso($iso,[
                            'official_name' => $data_country[$iso]
                        ]);

                    }

                }
            }

        }else {
            $comand->line('<comment>The is any countries file</comment> any country was set.');
        }

        // $comand->line('<info>'.$this->label.':</info>'." successfully set.");
        // $comand->line('<error>'.$this->label.':</error>'." not successfully set.");
        // $comand->line('<comment>'.$this->label.':</comment>'." previously set.");
        // $comand->error("Role not exist.");
    }

    protected function getCountriesArrayFromCSV($filename = '', $delimiter = ','){

        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $counter = 0;
        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE){

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE){

                $data[$counter]['iso3166'] = $row[0];
                $data[$counter]['es'] = $row[1];
                $data[$counter]['en'] = $row[2];
                $data[$counter]['zone'] = $row[3];
                $counter++;

            }
            fclose($handle);
        }
        return $data;
    }

}
