<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>404 - {{ translate('Page not found') }}</title>
  <link rel="icon" href="/favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f4f6f9;
      color: #012970;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .error-wrapper {
      text-align: center;
      max-width: 600px;
      padding: 40px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .error-code {
      font-size: 120px;
      font-weight: bold;
      color: #012970;
      margin-bottom: 10px;
    }

    .error-title {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #012970;
    }

    .error-description {
      font-size: 16px;
      color: #555;
      margin-bottom: 30px;
    }

    .home-link {
      display: inline-block;
      padding: 12px 24px;
      background-color: #012970;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .home-link:hover {
      background-color: #021f59;
    }

    .icon {
      font-size: 50px;
      margin-bottom: 15px;
      color: #012970;
    }

    @media (max-width: 600px) {
      .error-code {
        font-size: 80px;
      }

      .error-title {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>
  <div class="error-wrapper">
    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
    <div class="error-code">404</div>
    <div class="error-title">{{ translate('Oops! Page not found') }}</div>
    <div class="error-description">
      {{ translate('Sorry, the page you are looking for might have been removed or is temporarily unavailable.') }}
    </div>
    <a href="/dashboard" class="home-link">
      <i class="fas fa-home"></i> {{ translate('Go to Home Page') }}
    </a>
  </div>
</body>
</html>
