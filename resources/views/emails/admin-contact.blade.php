<!DOCTYPE html>
<html>
<head>
    <title>{{ $assunto }}</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #1f2937; background-color: #f9fafb; margin: 0; padding: 20px;">
    <div style="max-w-xl mx-auto bg-white; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; padding: 40px; margin-top: 20px;">
        <h2 style="font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 24px;">Olá, {{ $user->name }}!</h2>
        <p style="margin-bottom: 20px;">Você recebeu uma mensagem da administração do sistema:</p>
        
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 6px; border: 1px solid #e5e7eb; margin: 24px 0;">
            {!! nl2br(e($mensagem)) !!}
        </div>

        <p style="margin-top: 24px;">Atenciosamente,<br><strong>Equipe de Suporte</strong></p>
    </div>
</body>
</html>