<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pendaftaran Baru</title>
</head>
<body style="margin:0; padding:0; background:#F4F6F8; font-family:'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#141B23;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F6F8; padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#FFFFFF; border-radius:14px; overflow:hidden; box-shadow:0 8px 24px rgba(10,14,20,0.08);">
                <tr>
                    <td style="background:linear-gradient(135deg,#7FD8FF,#1E6FA8); padding:28px 32px;">
                        <p style="margin:0; font-size:12px; letter-spacing:0.08em; text-transform:uppercase; color:rgba(10,14,20,0.65); font-weight:700;">
                            NAC Swim School
                        </p>
                        <h1 style="margin:6px 0 0; font-size:20px; color:#0A0E14;">Pendaftaran Baru Masuk</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; width:160px; vertical-align:top;">Nama Lengkap</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; font-weight:700; color:#0A0E14;">{{ $data['name'] }}</td>
                            </tr>
                            @if (!empty($data['nickname']))
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Nama Panggilan</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">{{ $data['nickname'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Tanggal Lahir</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">
                                    {{ \Carbon\Carbon::parse($data['birth_date'])->translatedFormat('d F Y') }}
                                    ({{ \Carbon\Carbon::parse($data['birth_date'])->age }} tahun)
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">No. WhatsApp</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $data['whatsapp']) }}" style="color:#1E6FA8; text-decoration:none;">{{ $data['whatsapp'] }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#6B7A8A; vertical-align:top;">Kategori Diminati</td>
                                <td style="padding:10px 0; font-size:14px; font-weight:700; color:#1E6FA8;">{{ $data['category'] }}</td>
                            </tr>
                        </table>

                        @if (!empty($data['photo_path']))
                        <p style="margin:20px 0 0; font-size:13px; color:#6B7A8A;">
                            📎 Pas foto murid terlampir di email ini.
                        </p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px; background:#F4F6F8;">
                        <p style="margin:0; font-size:12px; color:#6B7A8A;">
                            Email ini dikirim otomatis dari formulir pendaftaran di website NAC Swim School.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>