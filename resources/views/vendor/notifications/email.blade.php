<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->

    <style type="text/css">

        .ReadMsgBody { width: 100%; background-color: white; }
        .ExternalClass { width: 100%; background-color: white; }
        body { width: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; font-family: Arial, Times, serif }
        table { border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }

        @-ms-viewport{ width: device-width; }

        @media only screen and (max-width: 639px){
        .wrapper{ width:100%;  padding: 0 !important; }
        }

        @media only screen and (max-width: 480px){
        .centerClass{ margin:0 auto !important; }
        .imgClass{ width:100% !important; height:auto; }
        .wrapper{ width:320px; padding: 0 !important; }
        .header{ width:320px; padding: 0 !important; background-image: url(http://placehold.it/320x400) !important; }
        .container{ width:300px;  padding: 0 !important; }
        .mobile{ width:300px; display:block; padding: 0 !important; text-align:center !important;}
        .mobile50{ width:300px; padding: 0 !important; text-align:center; }
        *[class="mobileOff"] { width: 0px !important; display: none !important; }
        *[class*="mobileOn"] { display: block !important; max-height:none !important; }
        }

    </style>

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php

$style = [

    /* Layout ------------------------------ */
    'body' => '',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #231F20;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',

    /* Nice to Have Styles */
        'main-color'  =>  '#231F20',
];
?>

<?php $fontSans = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>
<?php $fontSerif = 'font-family: Times, Times New Roman;'; ?>

<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" style="{{ $fontSans }} margin:0; padding:0; min-width: 100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">

    <!--[if !mso]><!-- -->
    <img style="min-width:640px; display:block; margin:0; padding:0" class="mobileOff" width="640" height="1" src="http://s14.postimg.org/7139vfhzx/spacer.gif">
    <!--<![endif]-->

    <!-- Start Background -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="white">
        <tr>
            <td width="100%" valign="top" align="center">

                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="{{ $style['main-color'] }}">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                    </tr>
                </table>
                <!-- End Wrapper -->

                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" border="0" class="wrapper">
                    <tr>
                        <td height="40" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                    </tr>
                    <tr>
                        <td align="center">

                            <!-- Start Container -->
                            <table width="600" height='70' cellpadding="0" cellspacing="0" border="0" class="container">
                                <tr>
                                    <td class="mobile" style="{{ $fontSans }} font-size:12px; line-height:18px;" align="center">
                                        <img src="{{ asset('images/NTHLogoNegro.png') }}" width="280" height="" style="margin:0; padding:0; border:none; display:block;" border="0" class="centerClass" alt="" />
                                    </td>
                                </tr>
                            </table>
                            <!-- End Container -->

                        </td>
                    </tr>
                    <tr>
                        <td height="40" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                    </tr>
                </table>
                <!-- End Wrapper -->

                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" align="center" border="0" class="wrapper" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#ffffff">

                                <!-- Start Container -->
                                <table width="600" cellpadding="0" cellspacing="0" align="center" border="0" class="container">
                                    <tr>
                                        <td align="center" class="mobile" style="{{ $fontSans }} font-size:16px; line-height:22px; letter-separation: 2px;color: #3A3838;">
                                            @if (! empty($greeting))
                                                {!! $greeting !!}
                                            @else
                                                @if ($level == 'error')
                                                    Whoops!
                                                @else
                                                    Hola!
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="line-height:10px; font-size:10px;"> </td><!-- Spacer -->
                                    </tr>
                                    <!-- Intro -->
                                    @foreach ($introLines as $line)
                                    <tr>
                                        <td align="center" style="{{ $fontSans }}  font-size: 18px; color: #000; line-height:20px;">
                                            {!! $line !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                                    </tr>
                                    @endforeach
                                    @if (isset($actionText))
                                        <tr>
                                            <td height="80" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <?php
                                                    switch ($level) {
                                                        case 'success':
                                                            $actionColor = 'button--green';
                                                            break;
                                                        case 'error':
                                                            $actionColor = 'button--red';
                                                            break;
                                                        default:
                                                            $actionColor = 'button--blue';
                                                    }
                                                ?>

                                                <a href="{{ $actionUrl }}"
                                                    target="_blank"
                                                    alias=""
                                                    style="{{ $fontSans }} text-decoration: none; color: #000; text-transform:uppercase; letter-spacing:1px;border: 1px solid #B9B8B8;padding: 0.5em;">
                                                    {{ $actionText }}
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="100" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                                        </tr>
                                    @endif
                                </table>
                                <!-- End Container -->

                            </td>
                        </tr>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                    </tbody>
                </table>
                <!-- End Wrapper -->

                @if (isset($actionText))
                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" align="center" border="0" class="wrapper" style="border-top: 1px solid #BDBCBC;">
                    <tbody>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#ffffff">

                                <!-- Start Container -->
                                <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                    <tr>
                                        <td align="left" style="{{ $fontSans }}  font-size: 14px; color: #4d4d4d; line-height:18px;">
                                            Si tienes problemas dando click al botón "{{ $actionText }}", copia en tu navegador o da click en el enlace que esta aquí debajo.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="line-height:10px; font-size:10px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="left" style="{{ $fontSans }}  font-size: 14px; color: #4d4d4d; line-height:18px;">
                                            <a href="{{ $actionUrl }}" target="_blank" style="color:{{ $style['main-color'] }};text-decoration: underline; overflow-wrap: break-word;word-wrap: break-word;-ms-word-break: break-all;word-break: break-word;-ms-hyphens: auto;-moz-hyphens: auto;-webkit-hyphens: auto;hyphens: auto;">
                                                {{ $actionUrl }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Container -->

                            </td>
                        </tr>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                    </tbody>
                </table>
                <!-- End Wrapper -->
                @endif

                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" align="center" border="0" class="wrapper" bgcolor="{{ $style['main-color'] }}">
                    <tbody>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                        <tr>
                            <td align="center">

                                <!-- Start Container -->
                                <table width="600" cellpadding="0" cellspacing="0" align="center" border="0" class="container">
                                    <tr>
                                        <td align="center" class="mobile" style="font-size:20px; line-height:26px; color:#FFFFFF;">

                                            <!-- Start Container -->
                                            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                                <tr>
                                                    <td height="20" style="" class="mobileOn"></td>
                                                    <td width="200" class="mobile" style="font-size:16px; line-height:18px;" align="center">
                                                        <a href="{{ $social_networks['facebook']  or '#' }}" style="{{ $fontSerif }} color: white; text-decoration: none;">FACEBOOK</a>
                                                    </td>
                                                    <td height="20" style="" class="mobileOn"></td>
                                                    <td width="200" class="mobile" style="font-size:16px; line-height:18px;" align="center">
                                                        <a href="{{ $social_networks['instagram'] or '#' }}" style="{{ $fontSerif }} color: white; text-decoration: none;">INSTAGRAM</a>
                                                    </td>
                                                    <td height="20" style="" class="mobileOn"></td>
                                                    <td width="200" class="mobile" style="font-size:16px; line-height:18px;" align="center">
                                                        <a href="{{ $blog['url'] or '#' }}" style="{{ $fontSerif }} color: white; text-decoration: none;">BLOG</a>
                                                    </td>
                                            </table>
                                            <!-- End Container -->

                                        </td>
                                    </tr>
                                    @if (isset($outroLines) && !empty($outroLines[0]) )
                                    <tr>
                                        <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                                    </tr>
                                    @endif
                                    <!-- Outro -->
                                    @foreach ($outroLines as $line)
                                        @if (!empty($line))
                                            <tr>
                                                <td align="center" style="{{ $fontSans }}  font-size: 14px; color: #4d4d4d; line-height:18px; color:#FFFFFF;">
                                                    {!! $line !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                                <!-- End Container -->

                            </td>
                        </tr>
                        <tr>
                            <td height="40" style="line-height:20px; font-size:20px;"> </td><!-- Spacer -->
                        </tr>
                    </tbody>
                </table>
                <!-- End Wrapper -->



                <!-- Start Wrapper -->
                <table width="800" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                    </tr>
                    <tr>
                        <td align="center" style="{{ $fontSans }}  font-size:12px; line-height:18px;">

                            &copy; {{ date('Y') }}
                            <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>.
                            All rights reserved.
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                    </tr>
                </table>
                <!-- End Wrapper -->

            </td>
        </tr>
    </table>
    <!-- End Background -->

</body>
</html>
