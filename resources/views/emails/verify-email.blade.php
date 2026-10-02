<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, Helvetica, sans-serif; color: #333333; line-height: 1.5;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 580px; background-color: #ffffff; border: 1px solid #dddddd; border-radius: 4px; overflow: hidden;">
                    
                    {{-- Header Resmi --}}
                    <tr>
                        <td style="padding: 24px 30px; border-bottom: 2px solid #2563eb;">
                            <div style="font-size: 16px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">
                                SMK Swasta Dwitunggal 2 Tanjung Morawa
                            </div>
                            <div style="font-size: 12px; color: #666666; margin-top: 3px;">
                                Sistem Informasi Tracer Study Alumni
                            </div>
                        </td>
                    </tr>

                    {{-- Isi Email --}}
                    <tr>
                        <td style="padding: 30px;">
                            
                            <p style="margin: 0 0 16px 0; font-size: 14px; font-weight: bold; color: #222222;">
                                Yth. {{ $notifiable->name }},
                            </p>

                            <p style="margin: 0 0 14px 0; font-size: 14px; color: #444444; line-height: 1.6;">
                                Terima kasih telah melakukan registrasi pada sistem <strong>Tracer Study SMK Swasta Dwitunggal 2 Tanjung Morawa</strong>.
                            </p>

                            <p style="margin: 0 0 24px 0; font-size: 14px; color: #444444; line-height: 1.6;">
                                Untuk memverifikasi keabsahan alamat email Anda dan melanjutkan proses pendaftaran, silakan klik tombol di bawah ini:
                            </p>

                            {{-- Tombol Verifikasi Standar --}}
                            <div style="margin: 28px 0; text-align: center;">
                                <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 14px; font-weight: bold; text-decoration: none; padding: 11px 26px; border-radius: 4px;">
                                    Verifikasi Alamat Email
                                </a>
                            </div>

                            <p style="margin: 0 0 12px 0; font-size: 13px; color: #555555; line-height: 1.6;">
                                Tautan verifikasi ini akan kedaluwarsa dalam <strong>60 menit</strong>. Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.
                            </p>

                            <div style="margin-top: 30px; font-size: 13px; color: #333333; line-height: 1.6;">
                                Hormat kami,<br>
                                <strong>Pengelola Tracer Study</strong><br>
                                SMK Swasta Dwitunggal 2 Tanjung Morawa
                            </div>

                            {{-- Link Alternatif --}}
                            <div style="margin-top: 30px; padding-top: 16px; border-top: 1px solid #eeeeee; font-size: 12px; color: #777777; line-height: 1.5;">
                                Jika tombol di atas tidak dapat diklik, salin dan tempel alamat URL berikut ke browser Anda:<br>
                                <a href="{{ $url }}" style="color: #2563eb; word-break: break-all;">{{ $url }}</a>
                            </div>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 16px 30px; background-color: #f9f9f9; border-top: 1px solid #eeeeee; font-size: 11px; color: #777777; text-align: center; line-height: 1.5;">
                            <div style="font-weight: bold; color: #555555;">SMK Swasta Dwitunggal 2 Tanjung Morawa</div>
                            <div>Tanjung Morawa, Kab. Deli Serdang, Sumatera Utara</div>
                            <div style="margin-top: 4px; color: #999999;">&copy; {{ date('Y') }} Tracer Study. Seluruh hak cipta dilindungi.</div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
