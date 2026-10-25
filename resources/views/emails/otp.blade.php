<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رمز التحقق لتسجيل الدخول - عقارات صفران</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #1e293b;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 580px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;" cellspacing="0" cellpadding="0">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #101c26 0%, #1a2f40 100%); padding: 35px 30px; text-align: center;">
                            <div style="display: inline-block; background: rgba(163, 105, 57, 0.2); border: 1px solid rgba(212, 175, 55, 0.4); border-radius: 12px; padding: 10px 20px; margin-bottom: 12px;">
                                <span style="color: #d4af37; font-size: 1.15rem; font-weight: 700; letter-spacing: 1px;">⚜️ SAFRAN REAL ESTATE</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 1.4rem; font-weight: 700; letter-spacing: -0.5px;">
                                نظام إدارة عقارات صفران
                            </h1>
                            <p style="color: #94a3b8; margin: 6px 0 0; font-size: 0.88rem;">
                                البوابة الآمنة للموظفين وإدارة العقارات
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <p style="margin: 0 0 16px; font-size: 1.05rem; font-weight: 600; color: #0f172a;">
                                مرحباً، {{ $user->name }}
                            </p>
                            <p style="margin: 0 0 24px; font-size: 0.95rem; line-height: 1.7; color: #475569;">
                                لقد تلقينا طلباً للتحقق وتسجيل الدخول إلى حسابك في نظام إدارة عقارات صفران (الرقم الوظيفي: <strong style="color: #a36939;">{{ $user->employee_number ?? 'EMP-' . $user->id }}</strong>).
                                <br>
                                استخدم رمز التحقق المؤقت (OTP) أدناه لإتمام تسجيل الدخول أو استعادة الحساب:
                            </p>

                            <!-- OTP Box -->
                            <div style="background: #faf8f5; border: 2px dashed #d4af37; border-radius: 14px; padding: 25px 20px; text-align: center; margin: 25px 0;">
                                <span style="display: block; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 2px; color: #a36939; font-weight: 700; margin-bottom: 8px;">
                                    رمز التحقق الخاص بك (OTP)
                                </span>
                                <div style="font-size: 2.4rem; font-weight: 800; letter-spacing: 10px; color: #101c26; font-family: monospace; direction: ltr; margin: 10px 0;">
                                    {{ $otp }}
                                </div>
                                <span style="display: inline-block; background: #fef3c7; color: #92400e; font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; margin-top: 6px;">
                                    ⏱️ صالح لمدة 15 دقيقة فقط
                                </span>
                            </div>

                            <!-- English Note -->
                            <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; margin-top: 20px; text-align: left; direction: ltr;">
                                <p style="margin: 0 0 8px; font-size: 0.88rem; color: #64748b; line-height: 1.5;">
                                    <strong>Dear {{ $user->name }},</strong>
                                    <br>
                                    Use the 6-digit one-time passcode (OTP) above to log into your Safran CRM account. This code expires in 15 minutes.
                                </p>
                            </div>

                            <!-- Security Warning -->
                            <div style="background-color: #f8fafc; border-right: 4px solid #ef4444; border-radius: 8px; padding: 14px 16px; margin-top: 25px;">
                                <strong style="color: #b91c1c; font-size: 0.86rem; display: block; margin-bottom: 4px;">
                                    ⚠️ تنبيه أمني / Security Notice:
                                </strong>
                                <p style="margin: 0; font-size: 0.82rem; color: #64748b; line-height: 1.6;">
                                    لا تشارك هذا الرمز مع أي شخص. فريق الدعم في شركة صفران لن يطلب منك هذا الرمز إطلاقاً.
                                    إذا لم تقم بطلب هذا الرمز، يُرجى تجاهل هذه الرسالة والتواصل مع مسؤول النظام.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 22px 30px; text-align: center;">
                            <p style="margin: 0; font-size: 0.8rem; color: #94a3b8; line-height: 1.6;">
                                &copy; {{ date('Y') }} شركة عقارات صفران - المملكة العربية السعودية. جميع الحقوق محفوظة.
                                <br>
                                Safran Real Estate CRM &bull; High-Security Employee Management Portal
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
