<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delay as a Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #0f0f0f;
            --fg: #eaeaea;
            --muted: #9a9a9a;
            --card: #171717;
            --border: #2a2a2a;
            --accent: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--fg);
            line-height: 1.5;
        }

        .wrap {
            max-width: 680px;
            padding: 48px 24px;
            margin: 0 auto;
        }

        h1 {
            font-size: 28px;
            margin: 0 0 12px;
            letter-spacing: -0.02em;
        }

        p {
            margin: 0 0 16px;
            color: var(--muted);
            font-size: 15px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
        }

        code {
            display: block;
            background: #0b0b0b;
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #dcdcdc;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            border: 1px solid var(--border);
            padding: 10px 14px;
            border-radius: 6px;
            color: var(--fg);
            font-size: 14px;
            background: transparent;
        }

        .btn:hover {
            border-color: var(--accent);
        }

        footer {
            margin-top: 48px;
            font-size: 13px;
            color: #6f6f6f;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Delay as a Service</h1>
        <p>An HTTP endpoint that waits before responding.</p>

        <div class="card">
            <code>
GET /delay<br>
GET /delay?ms=1000
            </code>

            <div class="actions">
                <a class="btn" href="/delay" target="_blank">Try /delay</a>
                <a class="btn" href="/delay?ms=1500" target="_blank">Try with delay</a>
            </div>
        </div>

        <p>
            It does not queue jobs.<br>
            It does not guarantee timing.<br>
            It simply waits.
        </p>

        <div class="card">
            <p><strong>Why does this exist?</strong></p>
            <p>
                Because time is a real dependency.<br>
                Because waiting is hard to test.<br>
                Because sometimes you need latency on purpose.
            </p>
        </div>

        <footer>
            Best-effort timing. No guarantees.<br>
            Stateless. Public. Minimal.
        </footer>
    </div>
</body>
</html>
