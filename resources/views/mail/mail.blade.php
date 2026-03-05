<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <header style="background-color: #004080; padding: 20px; text-align: center; color: white;">
            <h1 style="margin: 0; font-size: 24px;">Sistema de Gestión</h1>
            <p style="margin: 0; font-size: 16px;">Facultad de Ingeniería y Ciencias Hídricas - FICH</p>
        </header>
        <main style="padding: 10px;">
            <h2 style="font-size: 15px; color:rgba(1, 10, 17, 0.98); margin-top: 0;">Hola,</h2>
            <p style="line-height: 1.6;">{{ $body }}</p>
        </main>
        <footer style="background-color: #f4f4f9; padding: 10px; text-align: center; font-size: 12px; color: #666;">
            <p style="margin: 0;">Este mensaje fue generado automáticamente por el Sistema de Gestión.</p>
            <p style="margin: 0;">© 2025 FICH - Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>
