<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email - Tracer Study</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; color: #334155;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                {{-- Main Container Card --}}
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); border: 1px solid #e2e8f0;">
                    
                    {{-- Premium Gradient Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%); padding: 45px 35px 35px 35px; text-align: center;">
                            
                            {{-- Logo Box --}}
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0 auto 18px auto;">
                                <tr>
                                    <td style="background-color: #ffffff; padding: 10px 14px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo SMK" width="44" height="44" style="display: block; width: 44px; height: 44px; object-contain: contain; margin: 0 auto;">
                                    </td>
                                </tr>
                            </table>

                            {{-- Badge --}}
                            <div style="display: inline-block; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 30px; padding: 5px 16px; margin-bottom: 14px;">
                                <span style="color: #c7d2fe; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
                                    ✦ PORTAL TRACER STUDY RESMI
                                </span>
                            </div>

                            {{-- School Title --}}
                            <h2 style="margin: 0 0 8px 0; color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: -0.3px; line-height: 1.3;">
                                SMK SWASTA BUDHI DARMA INDRAPURA
                            </h2>
                            <p style="margin: 0; color: #a5b4fc; font-size: 13px; font-weight: 500;">
                                Sistem Pelacakan Karir & Jejaring Alumni Terpadu
                            </p>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 40px 35px;">
                            
                            {{-- Greeting --}}
                            <h3 style="margin: 0 0 16px 0; color: #0f172a; font-size: 19px; font-weight: 800; line-height: 1.3;">
                                Halo, Rekan Alumni <span style="color: #4f46e5;">{{ $notifiable->name }}</span>! 👋
                            </h3>

                            <p style="margin: 0 0 18px 0; font-size: 14px; line-height: 1.7; color: #475569;">
                                Terima kasih telah berpartisipasi dan mendaftarkan akun Anda di sistem <strong>Tracer Study SMK Swasta Budhi Darma Indrapura</strong>. Partisipasi Anda sangat berarti bagi pengembangan kualitas mutu pendidikan vokasi almamater kita serta mempererat sinergi sesama alumni.
                            </p>

                            <p style="margin: 0 0 28px 0; font-size: 14px; line-height: 1.7; color: #475569;">
                                Untuk memastikan bahwa ini benar-benar Anda serta mengamankan kepemilikan akun, silakan klik tombol konfirmasi di bawah ini:
                            </p>

                            {{-- CTA Button --}}
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0 auto 35px auto;">
                                <tr>
                                    <td align="center" style="border-radius: 12px; background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);">
                                        <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 16px 38px; font-family: inherit; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 12px; border: 1px solid #4338ca; box-shadow: 0 8px 18px -4px rgba(79, 70, 229, 0.45); letter-spacing: 0.3px;">
                                            Konfirmasi & Aktivasi Email Saya →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Steps Info Card --}}
                            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 12px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 12px;">
                                            📋 Alur Langkah Selanjutnya:
                                        </div>
                                        <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="24" valign="top" style="font-size: 13px; color: #4f46e5; font-weight: 800;">1.</td>
                                                <td style="font-size: 13px; color: #475569; padding-bottom: 8px;"><strong>Klik tombol di atas</strong> untuk memvalidasi alamat email Anda.</td>
                                            </tr>
                                            <tr>
                                                <td width="24" valign="top" style="font-size: 13px; color: #4f46e5; font-weight: 800;">2.</td>
                                                <td style="font-size: 13px; color: #475569; padding-bottom: 8px;"><strong>Verifikasi Admin:</strong> Akun Anda akan divalidasi oleh administrator sekolah.</td>
                                            </tr>
                                            <tr>
                                                <td width="24" valign="top" style="font-size: 13px; color: #4f46e5; font-weight: 800;">3.</td>
                                                <td style="font-size: 13px; color: #475569;"><strong>Mulai Mengisi Kuesioner:</strong> Login dan isi jejak karir Anda dengan mudah.</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Security Notice --}}
                            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #fefce8; border: 1px solid #fef08a; border-radius: 10px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 12px; line-height: 1.6; color: #854d0e;">
                                        <strong>🔒 Catatan Keamanan:</strong> Tautan verifikasi ini hanya berlaku selama <strong>60 menit</strong>. Jika Anda merasa tidak pernah mendaftar di sistem Tracer Study ini, silakan abaikan pesan ini, data Anda tetap aman.
                                    </td>
                                </tr>
                            </table>

                            {{-- Direct URL Fallback --}}
                            <p style="margin: 0; font-size: 12px; line-height: 1.6; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke browser Anda:<br>
                                <a href="{{ $url }}" style="color: #6366f1; word-break: break-all; text-decoration: underline;">{{ $url }}</a>
                            </p>

                        </td>
                    </tr>

                    {{-- Modern Dark Footer --}}
                    <tr>
                        <td style="background-color: #090d16; padding: 30px 35px; text-align: center; border-top: 1px solid #1e293b;">
                            <p style="margin: 0 0 6px 0; color: #f8fafc; font-size: 13px; font-weight: 700;">
                                Tracer Study Alumni • SMK Swasta Budhi Darma Indrapura
                            </p>
                            <p style="margin: 0 0 12px 0; color: #64748b; font-size: 11px; line-height: 1.5;">
                                Jl. Datuk Umar Palangki, Tanah Merah, Kec. Air Putih, Indrapura, Kab. Batu Bara, Sumatera Utara
                            </p>
                            <div style="font-size: 11px; color: #475569;">
                                <span>Hubungi kami: <a href="mailto:budhidarma5@gmail.com" style="color: #818cf8; text-decoration: none;">budhidarma5@gmail.com</a></span>
                            </div>
                            <div style="margin-top: 15px; font-size: 11px; color: #334155;">
                                &copy; {{ date('Y') }} SMK Swasta Budhi Darma Indrapura. Seluruh hak cipta dilindungi undang-undang.
                            </div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
