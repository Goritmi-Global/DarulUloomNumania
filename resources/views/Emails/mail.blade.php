<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <title>جواب موصول ہوا</title>
</head>
<body style="font-family: 'Jameel Noori Nastaleeq', Tahoma, sans-serif; direction: rtl; background-color: #f7f7f7; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background: #fff; border: 1px solid #ddd; padding: 30px; border-radius: 8px;">
        
        {{-- Title --}}
        <h2 style="text-align: center; color: #174696; margin-bottom: 30px;">
            {{ $website_name }}
        </h2>

        {{-- Greeting --}}
        <p style="font-size: 16px;"> محترم  {{ $user_name }}،</p>

        {{-- Body --}}
        <p style="font-size: 16px; line-height: 1.6;">
            آپ کے سوال کا جواب تیار کر دیا گیا ہے۔ برائے کرم نوٹ کریں کہ آپ کے سوال کا فتوی نمبر درج ذیل ہے:
        </p>

        <p style="font-size: 18px; font-weight: bold; color: #174696;">
            فتوی نمبر: {{ $fatwa_number }}
        </p>

        {{-- Button --}}
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background-color: #174696; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                مکمل جواب دیکھیں
            </a>
        </div>

        {{-- Footer --}}
        <p style="font-size: 16px; margin-top: 30px;">
            شکریہ <br>
            {{ $website_name }}
        </p>
    </div>

</body>
</html>
