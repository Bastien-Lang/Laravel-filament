<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 8px; }
        .header { text-align: center; border-bottom: 2px solid #38c172; padding-bottom: 10px; }
        .content { padding: 20px 0; }
        .details { background-color: #f8fafc; padding: 15px; border-radius: 5px; margin: 20px 0; text-align: center; }
        .footer { font-size: 0.8em; color: #777; text-align: center; margin-top: 20px; }
        .button { display: inline-block; padding: 12px 25px; background-color: #38c172; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #38c172;">Votre avis nous intéresse !</h1>
        </div>

        <div class="content">
            <p>Bonjour,</p>
            
            <p>Vous avez récemment participé à l'événement <strong>{{ $event->title }}</strong> et nous espérons que vous avez passé un excellent moment.</p>

            <div class="details">
                <p>Pour nous aider à nous améliorer, pourriez-vous prendre 30 secondes pour nous partager votre expérience ?</p>
                <p style="margin-top: 20px;">
                    <a href="{{ route('feedback.show', ['token' => $registration->feedback_token]) }}" class="button">
                        Donner mon avis
                    </a>
                </p>
            </div>

            <p>Merci encore pour votre participation et à très bientôt pour de prochains événements !</p>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé suite à votre participation à l'événement du {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}.</p>
            <p>Équipe {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>