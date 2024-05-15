<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <style>
            body {
                background-color: #f0f0f0;

                table#content {
                    width: 90%;
                    max-width: 800px;
                    background-color: #fff;
                    padding: 20px;
                    margin: auto;
                }

                a {
                    border-radius: 5px;
                    background-color: #ccc;
                    color: #000;
                    text-decoration: none;
                    padding: 5px 10px;
                    margin-top: 10px;
                }
            }
        </style>
    </head>
    <body>
        <table id="content">
            <tr>
                <td>
                    <p><strong>Keahlian anda telah luput</strong></p>
                    <p>{{ $user->name }},</p>
                    <p>
                        Sila ambil maklum bahawa kami tidak menerima sebarang
                        bayaran untuk pembaharuan keahlian anda. Oleh demikian
                        mandaat anda di Gym kami telah ditamatkan.
                    </p>
                    <p>
                        Anda masih boleh login untuk memperbaharui keahlian anda
                        sekiranya masih mahu menikmati kemudahan di Gym.
                    </p>
                    <p>Terima kasih.</p>
                    <p>
                        <a href="{{ route('dashboard') }}">
                            Login untuk membuat pembayaran.
                        </a>
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>
