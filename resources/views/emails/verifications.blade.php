@component('mail::message')
# Account Verification Code

Hello there!

Thank you for using our service. To complete your account verification, please use the following code:

@component('mail::panel')
# Verification Code: {{ $resetCode }}
@endcomponent

This code will expire in 15 minutes for security reasons. If you didn't request this verification, please ignore this email.

Best regards,
Active Advertising
@endcomponent
