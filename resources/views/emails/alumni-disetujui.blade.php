<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Akun Alumni</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, Helvetica, sans-serif; color: #333333; line-height: 1.6;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 580px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    
                    {{-- Header Resmi --}}
                    <tr>
                        <td style="padding: 24px 30px; border-bottom: 2px solid #16a34a; background-color: #ffffff;">
                            <div style="font-size: 16px; font-weight: bold; color: #166534; text-transform: uppercase; letter-spacing: 0.5px;">
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
                                Halo, {{ $alumni->nama }}!
                            </h3>

                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #334155; line-height: 1.7;">
                                Kabar gembira! Pendaftaran akun Tracer Study Anda di <strong>SMK Swasta Dwitunggal 2 Tanjung Morawa</strong> telah berhasil diverifikasi dan disetujui oleh Administrator sekolah.
                            </p>

                            <p style="margin: 0 0 24px 0; font-size: 14px; color: #334155; line-height: 1.7;">
                                Akun Anda sekarang telah <strong>aktif sepenuhnya</strong>. Anda dapat masuk ke dalam sistem untuk mengisi kuesioner pelacakan karir alumni dan memperbarui profil Anda.
                            </p>

                            {{-- Tombol Masuk --}}
                            <div style="margin: 28px 0; text-align: center;">
                                <a href="{{ $loginUrl }}" target="_blank" style="display: inline-block; background-color: #16a34a; color: #ffffff; font-size: 14px; font-weight: bold; text-decoration: none; padding: 13px 30px; border-radius: 6px; box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);">
                                    Masuk ke Akun Sekarang &rarr;
                                </a>
                            </div>

                            <p style="margin: 0 0 16px 0; font-size: 13px; color: #475569; line-height: 1.6;">
                                Terima kasih atas partisipasi aktif Anda dalam membantu pemetaan mutu lulusan almamater tercinta!
                            </p>

                            <div style="margin-top: 28px; font-size: 13px; color: #334155; line-height: 1.6;">
                                Salam hangat,<br>
                                <strong>Pengelola Tracer Study</strong><br>
                                SMK Swasta Dwitunggal 2 Tanjung Morawa
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
