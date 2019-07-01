<?php
/**
 * verifica que si la  futa contiene el string buscado
 * @param  string  $page_slug slug de la pagina a pasar
 * @return boolean            si se encuentra en la fruta o no
 */
function is_page($route_name)
{
    return Route::currentRouteName() == $route_name;
}

/**
 * verifica que si la  futa contiene el string buscado
 * @param  string  $page_slug slug de la pagina a pasar
 * @return boolean            si se encuentra en la fruta o no
 */
function in_pages(array $route_names)
{
    return in_array(Route::currentRouteName(), $route_names);
}

/**
 * verifica que si la  futa contiene el string buscado
 * @param  string  $page_slug slug de la pagina a pasar
 * @return boolean            si se encuentra en la fruta o no
 */
function is_exact_page($route_name,array $parameters)
{
    return Request::url() == route($route_name,$parameters);
}

/**
 * encrypta el mail
 * @param  string $mail        mail encriptasrse
 * @param  string $key         llave de encryptacion
 * @return string              valor encriptado
 */
function cltvoMailEncode($mail)
{
    $iv = getIVKey();

    $key = env("CLTVO_ENCRYPTION_KEY" ,'#&$sdfx2s7sffgg4');

    return  base64url_encode( openssl_encrypt( $mail, Config::get('app.cipher'), md5($key), OPENSSL_RAW_DATA, $iv));
}


/**
 * desencrypta el mail encryptado con la la funcion cltvoMailEnconde
 * @param  string $encodedMail mail encryptado con la la funcion cltvoMailEnconde
 * @param  string $key         llave de encryptacion
 * @return string              valor desencriptado
 */
function cltvoMailDecode($encodedMail)
{
    $iv = getIVKey();

    $key = env("CLTVO_ENCRYPTION_KEY" ,'#&$sdfx2s7sffgg4');

    return openssl_decrypt( base64url_decode($encodedMail), Config::get('app.cipher'), md5($key), OPENSSL_RAW_DATA, $iv);
}

function getIVKey()
{
    $app_key    = env('APP_KEY');
    $cipher     = Config::get('app.cipher');
    $iv_lenght  = openssl_cipher_iv_length($cipher);
    $iv_base64  = explode(':', $app_key)[1];
    $iv         = base64_decode($iv_base64);

    return substr($iv, $iv_lenght);
}

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

/**
 * coleccion con la que vamos a traer elemntos aleatorios
 * @param  IlluminateDatabaseEloquentCollection $Colection coleccion de elenntos
 * @return IlluminateDatabaseEloquentCollection coleccion de elemntos aleatorios
 */
function getRandomElements(Illuminate\Database\Eloquent\Collection $Colection)
{

    $ColectionRandom = new Illuminate\Database\Eloquent\Collection ;

    $ColectionRandNumber = rand( 0, $Colection->count() ) ;

    if ( $ColectionRandNumber > 0 ) {

        $ColectionRandom = $Colection->random( $ColectionRandNumber ) ;

        if ( get_class($ColectionRandom) != "Illuminate\Database\Eloquent\Collection" ) {
            $ColectionRandom = (new Illuminate\Database\Eloquent\Collection)->add($ColectionRandom) ;
        }

    }

    return  $ColectionRandom;
}

function csv_to_array($filename='', $delimiter=','){

    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $counter = 0;
    $header = NULL;
    $data = [];

    if ( ( $handle = fopen($filename, 'r') ) !== FALSE ){

        while ( ( $row = fgetcsv($handle, 1000, $delimiter) ) !== FALSE){

            if(!$header){
                $row[] = 'state_slug';
                $row[] = 'mun_slug';
                $header = $row;
            }else{
                $row[] = str_slug($row[0]);
                $row[] = str_slug($row[1]);
                $data[] = array_combine($header, $row);
            }

        }
        fclose($handle);
    }
    return $data;
}


function youtube_regex($url)
{
	$youtube_regex = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
	preg_match($youtube_regex, $url,$matches );
	return $matches;
}

function is_youtube_url($url)
{
	 return !empty( youtube_regex($url) );
}

function youtube_url_to_embed($url)
{
	$matches = youtube_regex($url);

	return isset($matches[1]) ? "https://www.youtube.com/embed/".$matches[1]."?rel=0&controls=0" : null;
}

function google_maps_regex($url)
{
	$google_maps_regex = '~^(?:https?://)?(?:(www|maps)[.])?(?:google(\.|/).*/maps/place/).*$~x';
	preg_match($google_maps_regex, $url,$matches );
	return $matches;
}


function is_google_maps_url($url)
{
	return !empty( google_maps_regex($url) );
}

function google_maps_url_to_embed($url)
{
	$parts = explode("/",$url);

	$key = array_search("place" , $parts);

	if ($key !== false) {
		$key = array_search("place" , $parts);
		$mode = "place";
		$parameters = "&q=".$parts[$key+1];
		return "https://www.google.com/maps/embed/v1/".$mode."?key=".env("GOOGLE_MAPS_EMBED_KEY")."&".$parameters;
	}

	return null;

}

function clean_classes_and_inline_styles($string)
{

	return clean_inline_styles(clean_classes($string));
}

function clean_inline_styles($string)
{
	$inline_styles_regex = '/style\s*=\s*[\"|\'].*[\"|\']/';

	return preg_replace_callback(
		$inline_styles_regex,
		function ($matches) {
			return str_replace($matches[0], "", $matches[0] );;
		},
		$string
	);
}

function clean_classes($string)
{
	$inline_styles_regex = '/class\s*=\s*[\"|\'].*[\"|\']/';

	return preg_replace_callback(
		$inline_styles_regex,
		function ($matches) {
			return str_replace($matches[0], "", $matches[0] );;
		},
		$string
	);
}


function clear_string( $str , $what = NULL , $with = ' ' )
{
    if( $what === NULL )
    {
        //  Character      Decimal      Use
        //  "\0"            0           Null Character
        //  "\t"            9           Tab
        //  "\n"           10           New line
        //  "\x0B"         11           Vertical Tab
        //  "\r"           13           New Line in Mac
        //  " "            32           Space

        $what   = "\\x00-\\x20";    //all white-spaces and control chars
    }

    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}

function updateMYSQLTimestamp()
{
    App\Http\Helpers\CacheHelper::updateMYSQLTimestamp();
}

function isShopCacheUpdated()
{
    return App\Http\Helpers\CacheHelper::isCacheUpdated();
}
