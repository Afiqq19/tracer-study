<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun Alumni</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, Helvetica, sans-serif; color: #333333; line-height: 1.6;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 580px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    
                    {{-- Header Resmi --}}
                    <tr>
                        <td style="padding: 24px 30px; border-bottom: 2px solid #2563eb; background-color: #ffffff;">
                            <div style="font-size: 16px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.5px;">
                                SMK SWASTA DWITUNGGAL 2 TANJUNG MORAWA
                            </div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                Sistem Informasi Tracer Study & Jejaring Alumni Terpadu
                            </div>
                        </td>
                    </tr>

                    {{-- Isi Email --}}
                    <tr>
                        <td style="padding: 30px;">
                            
                            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: bold; color: #0f172a;">
                                Halo, Rekan Alumni {{ $notifiable->name }}!
                            </h3>

                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #334155; line-height: 1.7;">
                                Terima kasih telah berpartisipasi dan mendaftarkan akun Anda di sistem <strong>Tracer Study SMK Swasta Dwitunggal 2 Tanjung Morawa</strong>. Partisipasi Anda sangat berarti bagi pengembangan kualitas mutu pendidikan vokasi almamater kita serta mempererat sinergi sesama alumni.
                            </p>

                            <p style="margin: 0 0 24px 0; font-size: 14px; color: #334155; line-height: 1.7;">
                                Untuk memastikan bahwa ini benar-benar Anda serta mengamankan kepemilikan akun, silakan klik tombol konfirmasi di bawah ini:
                            </p>

                            {{-- Tombol Konfirmasi & Aktivasi --}}
                            <div style="margin: 28px 0; text-align: center;">
                                <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 14px; font-weight: bold; text-decoration: none; padding: 13px 30px; border-radius: 6px; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);">
                                    Konfirmasi & Aktivasi Email Saya &rarr;
                                </a>
                            </div>

                            {{-- Alur Langkah Selanjutnya --}}
                            <div style="margin: 28px 0; padding: 18px 20px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
                                <div style="font-size: 13px; font-weight: bold; color: #1e293b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Alur Langkah Selanjutnya:
                                </div>
                                <ol style="margin: 0; padding-left: 20px; font-size: 13px; color: #475569; line-height: 1.8;">
                                    <li><strong>Klik tombol di atas</strong> untuk memvalidasi alamat email Anda.</li>
                                    <li><strong>Verifikasi Admin:</strong> Akun Anda akan divalidasi oleh administrator sekolah.</li>
                                    <li><strong>Mulai Mengisi Kuesioner:</strong> Login dan isi jejak karir Anda dengan mudah.</li>
                                </ol>
                            </div>

                            {{-- Catatan Keamanan (10 Menit) --}}
                            <div style="margin: 20px 0; padding: 14px 18px; background-color: #fefce8; border: 1px solid #fef08a; border-radius: 6px; font-size: 12px; color: #854d0e; line-height: 1.6;">
                                <strong>Catatan Keamanan:</strong> Tautan verifikasi ini hanya berlaku selama <strong>10 menit</strong>. Jika lewat dari 10 menit, tautan akan otomatis kedaluwarsa demi keamanan data Anda. Jika Anda merasa tidak pernah mendaftar di sistem Tracer Study ini, silakan abaikan pesan ini, data Anda tetap aman.
                            </div>

                            <div style="margin-top: 28px; font-size: 13px; color: #334155; line-height: 1.6;">
                                Hormat kami,<br>
                                <strong>Pengelola Tracer Study</strong><br>
                                SMK Swasta Dwitunggal 2 Tanjung Morawa
                            </div>

                            {{-- Link Alternatif --}}
                            <div style="margin-top: 26px; padding-top: 16px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b; line-height: 1.6;">
                                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke browser Anda:<br>
                                <a href="{{ $url }}" style="color: #2563eb; word-break: break-all; text-decoration: underline;">{{ $url }}</a>
                            </div>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 18px 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 11px; color: #64748b; text-align: center; line-height: 1.6;">
                            <div style="font-weight: bold; color: #334155;">SMK Swasta Dwitunggal 2 Tanjung Morawa</div>
                            <div>Tanjung Morawa, Kab. Deli Serdang, Sumatera Utara</div>
                            <div style="margin-top: 4px; color: #94a3b8;">&copy; {{ date('Y') }} Tracer Study. Seluruh hak cipta dilindungi.</div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
