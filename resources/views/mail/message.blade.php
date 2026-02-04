<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari {{ $data['name'] }} melalui Website Portofolio Anda.</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #0d6efd;">Pesan ini dari Website Portofolio Anda</h2>
        <hr>
        <p><strong>Nama:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Subjek:</strong> {{ $data['subject'] }}</p>
        <p><strong>Pesan:</strong></p>
        <div style="background: #f4f4f4; padding: 15px; border-radius: 5px;">
            {!! nl2br(e($data['message'])) !!}
        </div>
        <hr>
        <p style="font-size: 12px; color: #777;">Pesan ini dikirim otomatis melalui sistem Website Portofolio.</p>
    </div>
</body>
</html>