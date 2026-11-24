<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - {{ config('app.name') }}</title>
</head>

<body
    style="margin:0; padding:0; background-color:#f8f9fa; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif; color:#212529;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color:#f8f9fa; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width:600px; background-color:#ffffff; border:1px solid #dee2e6; border-radius:0.375rem; overflow:hidden;">
                    <tr>
                        <td style="background-color:#0d6efd; padding:20px 24px;">
                            <h1 style="margin:0; font-size:1.25rem; font-weight:600; color:#ffffff;">
                                {{ config('app.name') }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <h2 style="margin:0 0 16px; font-size:1.5rem; font-weight:500; color:#212529;">Halo
                                {{ $user->name }},</h2>
                            <p style="margin:0 0 12px; font-size:1rem; line-height:1.5; color:#212529;">
                                Terima kasih telah mendaftar di <strong>{{ config('app.name') }}</strong> menggunakan
                                akun Google (<strong>{{ $user->email }}</strong>).
                            </p>
                            <p style="margin:0 0 20px; font-size:1rem; line-height:1.5; color:#212529;">
                                Mulai sekarang Anda dapat login cukup dengan menekan tombol <strong>Login dengan
                                    Google</strong> tanpa perlu mengingat password.
                            </p>
                            <p style="margin:0 0 24px;">
                                <a href="{{ route('dashboard') }}"
                                    style="display:inline-block; background-color:#0d6efd; color:#ffffff; text-decoration:none; padding:0.5rem 1rem; font-size:1rem; font-weight:400; line-height:1.5; border-radius:0.375rem; border:1px solid #0d6efd;">Buka
                                    Dashboard</a>
                            </p>
                            <hr style="border:0; border-top:1px solid #dee2e6; margin:24px 0;">
                            <p style="margin:0 0 4px; font-size:0.875rem; line-height:1.5; color:#6c757d;">Salam,</p>
                            <p style="margin:0; font-size:0.875rem; font-weight:600; color:#212529;">Tim
                                {{ config('app.name') }}</p>
                        </td>
                    </tr>
                </table>
                <p style="margin:16px 0 0; font-size:0.75rem; color:#6c757d;">Email ini dikirim otomatis, mohon tidak
                    membalas.</p>
            </td>
        </tr>
    </table>
</body>

</html>
