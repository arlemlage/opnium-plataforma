<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&family=Outfit:wght@100..900&display=swap');

        /* Default */
        * {
            font-family: "Outfit", sans-serif !important;
        }
    </style>
</head>

<body
    style="
      margin: 0;
      padding: 0;
      background-color: #e3f1fc;
      font-family: Arial, sans-serif;
    ">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #e3f1fc; padding: 20px">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="
              background-color: #ffffff;
              overflow: hidden;
            ">
                    <!-- Header Section -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #e3f1fc">
                            <img src="{{ baseUrl() . '/' . siteSetting()->logo }}" alt="Company Logo">
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 40px; color: #333333">
                            <p
                                style="
                    margin: 0;
                    font-weight: 600;
                    font-size: 16px;
                    line-height: 1.5;
                  ">
                                Ticket Replied,
                            </p>
                            <p style="margin: 20px 0 0 0; font-size: 16px; line-height: 1.5">
                                {!! $mail_data['body'] !!}
                            </p>

                            <p style="margin: 20px 0 0 0; font-size: 16px; line-height: 1.5">
                                <strong>Regards,</strong><br />{{ siteSetting()->company_name ?? '' }}<br />{{ date('d/m/Y \a\t h:i a') }}
                            </p>
                            @if (isset($mail_data['comment_id']))
                                <!-- Button -->
                                <div style="margin: 30px 0 0px; text-align: center">
                                    <a href="{{ route('ticket-link', ['ticket_id' => $mail_data['ticket_id'], 'comment_id' => $mail_data['comment_id']]) }}"
                                        style="
                      background-color: #4e73df;
                      color: #ffffff;
                      text-decoration: none;
                      padding: 10px 20px;
                      font-size: 16px;
                      border-radius: 5px;
                      display: inline-block;
                    ">Ticket
                                        Details</a>
                                </div>
                            @else
                                <div style="margin: 30px 0 0px; text-align: center">
                                    <a href="{{ route('ticket-link', ['ticket_id' => $mail_data['ticket_id']]) }}"
                                        style="
                      background-color: #4e73df;
                      color: #ffffff;
                      text-decoration: none;
                      padding: 10px 20px;
                      font-size: 16px;
                      border-radius: 5px;
                      display: inline-block;
                    ">Ticket
                                        Details</a>
                                </div>
                            @endif
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td
                            style="
                  padding: 40px;
                  font-size: 16px;
                  line-height: 160%;
                  color: #2d2c2b;
                  padding-bottom: 25px;                  
                  padding-top: 0px;
                ">
                            <p style="margin: 0; text-align: left">
                                This is a system-generated email.
                                Please do not
                                reply to this email.<br />
                                This mailbox is not monitored. If you have any inquiries,
                                please contact
                                <a href="mailto:{{ siteSetting()->email ?? '' }}"
                                    style="color: #4e73df; text-decoration: none">{{ siteSetting()->email ?? '' }}</a>.
                            </p>
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="
            background-color: #f9f9f9;
            overflow: hidden;
          ">
                    <tr>
                        <td style="padding: 20px 40px; width: 50%;">
                            <p
                                style="font-style: normal;
                    font-weight: 400;
                    font-size: 16px;
                    margin: 0;
                    line-height: 160%;color: rgba(0, 0, 0, 0.6);">
                                Copyright &copy; {{ date('Y') }} All rights <br> reserved by
                                <strong style="color: #2D2C2B;">{{ siteSetting()->company_name ?? '' }}</strong>
                            </p>
                        </td>
                        <td style="padding: 20px 40px; width: 50%;">
                            <a href="{{ siteSetting()->facebook_url ?? '#' }}"
                                style="margin: 0 5px; text-decoration: none">
                                <img src="{{ asset('assets/frontend/img/new/facebook.png') }}" alt="">
                            </a>
                            <a href="{{ siteSetting()->instagram_url ?? '#' }}"
                                style="margin: 0 5px; text-decoration: none">
                                <img src="{{ asset('assets/frontend/img/new/instagram.png') }}" alt="">
                            </a>
                            <a href="{{ siteSetting()->dribble_url ?? '#' }}"
                                style="margin: 0 5px; text-decoration: none">
                                <img src="{{ asset('assets/frontend/img/new/pinterest.png') }}" alt="">
                            </a>
                            <a href="{{ siteSetting()->twitter_url ?? '#' }}"
                                style="margin: 0 5px; text-decoration: none">
                                <img src="{{ asset('assets/frontend/img/new/twitter.png') }}" alt="">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
