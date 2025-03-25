<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: white;
            color: #333;
            line-height: 1.6;
            font-size: 16px;
        }
 
        .background {
            background-color: rgba(244,244,244);
            width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Main container */
        .email-container {
            max-width: 650px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Full-width image styling */
        .email-header-image {
            width: 100%;
            height: 200px;
            display: block;
            max-width: 100%;
        }
        
        /* Content section */
        .content {
            padding: 30px;
        }
        
        h2 {
            margin-bottom: 13px;
            color: #154272;
            font-weight: 600;
            font-size: 20px;
        }
        
        p {
            margin-bottom: 5px;
            font-size: 16px;
            color: #444;
        }
        
        strong {
            font-weight: 600;
            color: #154272;
        }
        
        /* Signature */
        .signature {
            margin: 25px 0;
        }
        
        .team-name {
            font-weight: 600;
            color: #154272;
            font-size: 17px;
        }
        
        /* Logo section */
        .logo-section {
            text-align: center;
            padding: 10px 0 15px;
        }
        
        .company-logo-container {
            margin: 0 auto;
            width: 300px;
            max-width: 90%;
        }
        
        .company-logo-container img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        
        /* Footer section */
        .footer {
            text-align: center;
            padding: 25px 20px 30px;
            background-color: #ffffff;
        }
        
        .footer-info {
            margin: 0 auto;
            max-width: 80%;
        }
        
        .copyright {
            font-size: 14px;
            color: #444;
            margin: 6px 0;
        }
        
        .contact-info {
            font-size: 14px;
            color: #444;
            margin: 6px 0;
        }
        
        .contact-info a {
            color: #154272;
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer-links {
            margin-top: 6px;
        }
        
        .footer-links a {
            color: #154272;
            text-decoration: none;
            font-weight: 500;
        }
        
        /* Responsive design */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 25px;
            }
            .company-logo-container {
                width: 250px;
            }
            .footer-info {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="email-container">
            <!-- Image header with link -->
            <a href="https://wedebeek.com">
                <img src="https://i.imgur.com/u8PXBdN.png" alt="Wedebeek Header" class="email-header-image">
            </a>
            
            <div class="content">
                <h2>Dear <?php echo $firstname . " " . $lastname; ?>,</h2>
                
                <p>Thanks for verifying your email. Your application is completed and will be process within 3-5 business days.</p>
                
                <div class="signature">
                    <p>Best regards,</p>
                    <p class="team-name">Wedebeek Affiliate Team</p>
                </div>
            </div>
            
            <!-- Logo section with proper container -->
            <div class="logo-section">
                <div class="company-logo-container">
                    <img src="https://i.imgur.com/1GRiidm.png" alt="Wedebeek Logo">
                </div>
            </div>
            
            <div class="footer">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="padding-bottom:20px">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" width="62" style="padding: 0 10px;">
                                        <a href="https://www.facebook.com/teamwedebeek" style="display: block; width: 42px; height: 42px; line-height: 38px; border-radius: 50%; border: 2px solid #333; color: #333 !important; text-decoration: none !important; font-size: 20px; font-weight: 1000; text-align: center; background-color: #ffffff;">f</a>
                                    </td>
                                    <td align="center" width="62" style="padding: 0 10px;">
                                        <a href="https://www.linkedin.com/company/wedebeek" style="display: block; width: 42px; height: 42px; line-height: 38px; border-radius: 50%; border: 2px solid #333; color: #333 !important; text-decoration: none !important; font-size: 20px; font-weight: 1000; text-align: center; background-color: #ffffff;">in</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <div class="footer-info">
                    <p class="copyright">&copy; 2021 Wedebeek, Inc. All rights reserved.</p>
                    <p class="contact-info">Have any questions? Email us <a href="mailto:support@wedebeek.com">support@wedebeek.com</a></p>
                    <div class="footer-links">
                        <a href="https://wedebeek.com/v2/news/1">Privacy Policy</a> | <a href="https://wedebeek.com/v2/terms">Terms of Use</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>