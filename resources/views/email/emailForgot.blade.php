<!DOCTYPE html>
<html>

<head>
    <style>
        .button-verify {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }

        .content-email {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        h2 {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="content-email">
        <h2>Email Verification</h2>
        <p>Click the button below to reset your password:</p>
        <a href="{{ $url }}" class="button-verify">
            Reset Password
        </a>
    </div>
</body>

</html>