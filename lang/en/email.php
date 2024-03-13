<?php

return [
    'hello' => 'Hello',
    'regards' => 'Kind regards',
    'troubleClickingLink' => 'If you\'re having trouble clicking the ":actionText" button, copy and paste the following URL into your web browser: ',

    'resetPassword' => [
        'subject' => ':appName - Password Reset',
        'line1' => 'You are receiving this email because we have received a password reset request.',
        'resetPasswordButtonText' => 'Reset password',
        'line2' => 'This link is valid for :count minutes.',
        'line3' => 'If you have not submitted a reset request, you can ignore this email.',
    ],

    'verifyEmail' => [
        'subject' => ':appName - Welcome',
        'line1' => 'Welcome to *:appName*. Please activate your user account by clicking on the link below. The link is valid for :verificationLinkValidityInHours hours.',
        'line2' => 'This is your temporary password :password',
        'verifyEmailButtonText' => 'Activate user account',
        'line3' => "*Note:* If you haven't created an account, you don't need to do anything.",
    ],

    'applicantRegisterEmail' => [
        'title' => 'Welcome to Startfeld',
        'greeting' => 'Hi ',
        'application_token_message' => 'This is your person link to edit your application any time later.',
        'application_continue_message' => 'Edit application',
        'application_description_message' => 'You have started to fill out your application. You can continue it at any time by clicking on above link.'
    ],

    'applicationSubmittedEmail' => [
        'title' => 'Application sucessfully submitted',
        'greeting' => 'Hi ',
        'message' => 'Your application has been submitted successfully.',
        'admin_message' => 'Please have some patience while we process your application. You will be notified by email.',
    ],

    'applicationApprovedEmail' => [
        'title' => 'Application approved',
        'greeting' => 'Hi',
        'message' => 'Congratulations. Your application has been approved!',
        'admin_message' => 'You will be contacted shortly regarding next steps.',
    ],

    'applicationRejectedEmail' => [
        'title' => 'Application rejected',
        'greeting' => 'Hi',
        'message' => 'We are sorry, but we had to reject your application has been',
        'admin_message' => 'In case of any possible next steps, you will be contacted shortly.',
    ],

    'adminNotificationMail' => [
        'title' => 'Application submitted',
        'greeting' => 'Hi ',
        'message' => 'An applicant just submitted a new application.',
        'admin_message' => 'Please check the application.',
        'application_button' => 'Open application'
    ]
];
