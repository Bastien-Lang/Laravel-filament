<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 8px; }
        .header { text-align: center; border-bottom: 2px solid #3490dc; padding-bottom: 10px; }
        .content { padding: 20px 0; }
        .details { background-color: #f8fafc; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .footer { font-size: 0.8em; color: #777; text-align: center; margin-top: 20px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmation d'inscription</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $userName }}</strong>,</p>
            
            <p>Nous avons le plaisir de vous confirmer votre inscription à l'événement suivant :</p>

            <div class="details">
                <h2 style="margin-top: 0;">{{ $event->title }}</h2>
                <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y à H:i') }}</p>
                <p><strong>Lieu :</strong> {{ $event->location }}</p>
            </div>

            <p>Nous avons hâte de vous y retrouver !</p>
            
            <p style="text-align: center;">
                <a href="{{ $urlDetails }}" class="button">Voir les détails de l'événement</a>
            </p>
            <p style="text-align: center; margin-top: 10px;">
                <a href="{{ route('registration.cancel', $event) }}" class="button" style="background-color: #e74c3c;">Annuler l'inscription</a>
            </p>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement par l'équipe de {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>