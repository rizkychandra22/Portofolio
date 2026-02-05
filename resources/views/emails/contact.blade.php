<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Pesan Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f4f4f4; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background-color: #f4f4f4; padding: 10px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesan dari Web Portofolio</h1>
        </div>
        <div class="content">
            <p><strong>Nama:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Subjek:</strong> {{ $subject }}</p>
            <p><strong>Pesan:</strong></p>
            <p>{{ $messageContent }}</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim dari halaman kontak portofolio.</p>
        </div>
    </div>
</body>
</html>