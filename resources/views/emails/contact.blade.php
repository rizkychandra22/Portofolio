<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Pesan Baru</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        .header { background-color: #2563eb; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; background-color: #ffffff; }
        .item { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesan Portofolio Baru</h1>
        </div>
        <div class="content">
            <div class="item"><strong>Nama:</strong> {{ $name }}</div>
            <div class="item"><strong>Email:</strong> {{ $email }}</div>
            <div class="item"><strong>Subjek:</strong> {{ $subject }}</div>
            <div style="margin-top: 20px;">
                <strong>Isi Pesan:</strong>
                <p style="background: #f3f4f6; padding: 15px; border-radius: 5px;">{{ $messageContent }}</p>
            </div>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem Web Portofolio Anda.</p>
        </div>
    </div>
</body>
</html>