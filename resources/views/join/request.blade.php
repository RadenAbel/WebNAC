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
                            Nugroho Aquatic Club
                        </p>
                        <h1 style="margin:6px 0 0; font-size:20px; color:#0A0E14;">Pendaftaran Baru Masuk</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; width:150px; vertical-align:top;">Nama Lengkap</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; font-weight:700; color:#0A0E14;">{{ $data['name'] }}</td>
                            </tr>
                            @if(!empty($data['age']))
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Usia</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">{{ $data['age'] }} tahun</td>
                            </tr>
                            @endif
                            @if(!empty($data['gender']))
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Jenis Kelamin</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">{{ $data['gender'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">No. WhatsApp</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $data['whatsapp']) }}" style="color:#1E6FA8; text-decoration:none;">{{ $data['whatsapp'] }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Email</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">
                                    <a href="mailto:{{ $data['email'] }}" style="color:#1E6FA8; text-decoration:none;">{{ $data['email'] }}</a>
                                </td>
                            </tr>
                            @if(!empty($data['category']))
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:13px; color:#6B7A8A; vertical-align:top;">Kategori Diminati</td>
                                <td style="padding:10px 0; border-bottom:1px solid #EEF1F3; font-size:14px; color:#141B23;">{{ $data['category'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($data['message']))
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#6B7A8A; vertical-align:top;">Catatan</td>
                                <td style="padding:10px 0; font-size:14px; color:#141B23; line-height:1.6;">{{ $data['message'] }}</td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px; background:#F4F6F8;">
                        <p style="margin:0; font-size:12px; color:#6B7A8A;">
                            Email ini dikirim otomatis dari formulir Join Us di website Nugroho Aquatic Center.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>