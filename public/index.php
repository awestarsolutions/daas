<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delay as a Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #0f0f0f;
            color: #eaeaea;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 520px;
            padding: 24px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 12px;
        }
        p {
            font-size: 15px;
            line-height: 1.5;
            color: #bdbdbd;
        }
        code {
            display: block;
            background: #1b1b1b;
            padding: 12px;
            margin-top: 16px;
            border-radius: 6px;
            color: #dcdcdc;
            font-size: 14px;
        }
        .note {
            margin-top: 24px;
            font-size: 13px;
            color: #7a7a7a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delay as a Service</h1>
        <p>An HTTP endpoint that waits before responding.</p>

        <code>
GET /delay<br>
GET /delay?ms=1000
        </code>

        <p class="note">
            Best-effort timing. No guarantees.
        </p>
    </div>
</body>
</html>
