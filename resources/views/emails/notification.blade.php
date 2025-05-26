<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Email Template</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body style="font-family: 'Poppins', Arial, sans-serif">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <table class="content" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <!-- Header -->
                    <tr>
                        <td class="header" style="background-color: #345C72; padding: 40px; text-align: center; color: white; font-size: 24px;">
                        LEAVE APPLICATION FORM
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="body" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                        Hello Sir Marben,
                        <br><br>
                        EMPLOYEE {{$displayName}} HAS SUBMITTED A LEAVE REQUEST. PLEASE REVIEW THE DETAILS BELOW:
                        <br><br>
                        EMPLOYEE NAME: JHONNY SINS
                        LEAVE TYPE:[SICK LEAVE/ VACATION LEAVE/ PERSONAL LEAVE]
                        START DATE: [05/01/2025]
                        END DATE: [05/07/2025]
                        <br><br>
                        PLEASE REVIEW THE REQUEST AND TAKE NECESSARY ACTION.

                    </td>
                    </tr>

                    <!-- Call to action Button -->
                    <tr>
                        <td style="padding: 0px 40px 0px 40px; text-align: center;">
                            <!-- CTA Button -->
                            <table cellspacing="0" cellpadding="0" style="margin: auto;">
                                <tr>
                                    <td align="center" style="background-color: #345C72; padding: 10px 20px; border-radius: 5px;">
                                        <a href="https://www.yourwebsite.com" target="_blank" style="color: #ffffff; text-decoration: none; font-weight: bold;">GO TO DASHBOARD</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                    <td class="footer" style="background-color: #333333; padding: 40px; text-align: center; color: white; font-size: 14px;">
                        Copyright &copy; <span id="current-year"></span> | Villasis Water District
                    </td>

                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<style>
  @media screen and (max-width: 600px) {
    .content {
        width: 100% !important;
        display: block !important;
        padding: 10px !important;
    }
    .header, .body, .footer {
        padding: 20px !important;
    }
  }
</style>
<script>
    // Get the current year
    const currentYear = new Date().getFullYear();

    // Set the current year in the span with id "current-year"
    document.getElementById('current-year').textContent = currentYear;
</script>
</html>