<?php

return [
    'hello' => 'Hallo!',
    'regards' => 'Freundliche Grüsse',
    'troubleClickingLink' => 'Falls Sie mit dem Klick auf ":actionText" Probleme haben, kopieren Sie bitte nachstehenden Link in Ihren Browser: ',

    'resetPassword' => [
        'subject' => ':appName - Passwort zurücksetzen',
        'line1' => 'Sie erhalten dieses E-Mail, weil wir eine Anfrage zum Zurücksetzen des Passwortes erhalten haben.',
        'resetPasswordButtonText' => 'Passwort zurücksetzen',
        'line2' => 'Dieser Link ist :count Minuten gültig.',
        'line3' => 'Falls Sie keine Anfrage zum Zurücksetzen gestellt haben, können Sie dieses E-Mail ignorieren.',
    ],

    'verifyEmail' => [
        'subject' => ':appName - Willkommen',
        'line1' => 'Willkommen zum *:appName*. Bitte aktivieren Sie Ihr Benutzerkonto indem Sie auf untenstehenden Link klicken. Der Link ist :verificationLinkValidityInHours Stunden gültig.',
        'line2' => 'Das ist ihr temporäres Passwort: :password',
        'verifyEmailButtonText' => 'Benutzerkonto aktivieren',
        'line3' => '*Hinweis:* Falls Sie kein Konto erstellt haben, müssen Sie nichts unternehmen.',
    ],

    'applicantRegisterEmail' => [
        'title' => 'Antrags-Link',
        'greeting' => 'Hallo',
        'application_token_message' => 'Dies ist Ihr persönlicher Link, mit dem Sie Ihren Antrag später jederzeit bearbeiten können.',
        'application_continue_message' => 'Antrag bearbeiten',
        'application_description_message' => 'Sie haben begonnen, Ihren Antrag auszufüllen. Sie können sie jederzeit fortsetzen, indem Sie auf den obigen Link klicken.'
    ],

    'applicationSubmittedEmail' => [
        'title' => 'Antrag erfolgreich eingereicht',
        'greeting' => 'Hallo',
        'message' => 'Ihr Antrag wurde erfolgreich eingereicht.',
        'admin_message' => 'Bitte haben Sie etwas Geduld, während wir Ihre Bewerbung bearbeiten. Sie werden per E-Mail benachrichtigt.',
    ],

    'applicationApprovedEmail' => [
        'title' => 'Antrag angenommen',
        'greeting' => 'Hallo',
        'message' => 'Herzlichen Glückwunsch! Ihre Bewerbung ist genehmigt worden!',
        'admin_message' => 'Sie werden in Kürze bezüglich der weiteren Schritte kontaktiert werden.',
    ],

    'applicationRejectedEmail' => [
        'title' => 'Antrag abgelehnt',
        'greeting' => 'Hi',
        'message' => 'Es tut uns leid, aber Ihr Antrag wurde zurückgewiesen.',
        'admin_message' => 'Über eventuelle weitere Schritte würden wir Sie in Kürze informieren.',
    ],


    'adminNotificationMail' => [
        'title' => 'Antrag eingereicht',
        'greeting' => 'Hallo',
        'message' => 'Es wurde soeben ein neuer Antrag eingereicht.',
        'admin_message' => 'Bitte prüfen Sie nun den Antrag.',
        'application_button' => 'Antrag ansehen'
    ]
];
