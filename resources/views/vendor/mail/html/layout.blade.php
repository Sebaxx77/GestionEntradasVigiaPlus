<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        body {
            background-color: #f3f4f6; /* Color de fondo general */
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
        }

        .wrapper {
            width: 100%;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .content {
            margin: 0 auto;
            width: 100%;
            max-width: 600px; /* Ancho máximo para centrar */
            background-color: #ffffff; /* Fondo del cuerpo principal */
            border-radius: 4px;
            overflow: hidden; /* Para que el border-radius funcione correctamente */
        }

        .header {
            background-color: #EF841A;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #fff;
        }

        .body {
            padding: 20px;
        }

        .subcopy {
            background-color: #F3F4F6;
            padding: 10px;
            font-size: 14px;
            color: #555;
        }

        .footer {
            background-color: #1F2937;
            padding: 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
            color: #fff;
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="header">
                            <h1 style="margin: 10; font-size: 24px; color: #fff; text-align: center;">Vigia Plus Logistics</h1>
                        </td>
                    </tr>

                    <tr>
                        <td class="body">
                            {{ $slot }}
                        </td>
                    </tr>

                    @isset($subcopy)
                    <tr>
                        <td class="subcopy">
                            {{ $subcopy }}
                        </td>
                    </tr>
                    @endisset

                    <tr>
                        <td class="footer">
                            <p style="margin: 10px; font-size: 14px; color: #fff;">
                                © {{ date('Y') }} Vigia Plus Logistics. @lang('All rights reserved.')
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>