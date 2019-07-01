@php

    // dd(isShopCacheUpdated());
    //
    //

    use Illuminate\Support\Facades\Mail;
    use App\Mail\Cltvo\FatalErrorMail;

    Mail::to('developer.sr@elcultivo.mx')->send(new FatalErrorMail("01", ["hola"]));

@endphp
