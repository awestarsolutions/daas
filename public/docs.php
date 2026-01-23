<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delay as a Service — Documentation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #0e0e0e;
            --panel: #161616;
            --border: #2a2a2a;
            --text: #eaeaea;
            --muted: #9a9a9a;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.6;
        }

        .wrap {
            max-width: 860px;
            margin: 0 auto;
            padding: 56px 24px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        h2 {
            font-size: 18px;
            margin-top: 40px;
            margin-bottom: 12px;
        }

        p {
            font-size: 15px;
            color: var(--muted);
            margin-bottom: 16px;
        }

        ul {
            margin: 0 0 16px 18px;
            color: var(--muted);
        }

        li {
            margin-bottom: 6px;
        }

        code {
            display: block;
            background: #0b0b0b;
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #dcdcdc;
            margin: 12px 0;
            white-space: pre-wrap;
        }

        .note {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
            font-size: 14px;
            color: var(--muted);
        }

        a {
            color: inherit;
            text-decoration: none;
            border-bottom: 1px solid transparent;
        }

        a:hover {
            border-color: #666;
        }

        footer {
            margin-top: 64px;
            font-size: 13px;
            color: #6f6f6f;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
    </style>
</head>
<body>
<div class="wrap">

    <h1>Delay as a Service</h1>
    <p>Documentation</p>

    <div class="note">
        Delay as a Service (DaaS) is a minimal HTTP API that waits before responding.
        It is designed for testing latency, retries, and time-dependent behavior.
    </div>

    <h2>Philosophy</h2>

    <p>
        <strong>Time is a dependency.</strong>
    </p>

    <p>
        Modern systems depend on latency, retries, timeouts, and user perception — yet
        time is often mocked, skipped, or approximated during development.
    </p>

    <p>
        Delay as a Service exists to make time explicit.
    </p>

    <p>
        It does not simulate networks.<br>
        It does not emulate failures.<br>
        It simply waits.
    </p>

    <p>
        By treating time as a first-class input, developers can test loading states,
        retry logic, and user experience under real waiting conditions — without adding
        complexity or infrastructure.
    </p>

    <p>
        This service is intentionally minimal.<br>
        The constraint is the product.
    </p>

    <h2>Base URL</h2>
    <code>https://daas.awestar.solutions</code>

    <h2>Endpoints</h2>

    <h3>GET /delay</h3>
    <p>
        Returns a response after a short, random delay.
    </p>

    <code>
GET /delay
    </code>

    <h3>GET /delay?ms=&lt;milliseconds&gt;</h3>
    <p>
        Requests a specific delay duration.
    </p>

    <ul>
        <li>Minimum: 100 ms</li>
        <li>Maximum: 5000 ms</li>
        <li>Timing is best-effort</li>
    </ul>

    <code>
GET /delay?ms=1000
    </code>

    <h2>Successful Response</h2>

    <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": "ok",
  "delay_ms": 1000
}
    </code>

    <h2>Error Responses</h2>

    <p>Invalid request:</p>

    <code>
HTTP/1.1 400 Bad Request

{
  "status": "invalid_request",
  "message": "Delay must be between 100 and 5000 milliseconds."
}
    </code>

    <p>Rate limited or too many concurrent requests:</p>

    <code>
HTTP/1.1 429 Too Many Requests

{
  "status": "rate_limited"
}
    </code>

    <h2>Rate Limits</h2>

    <ul>
        <li>20 requests per minute per IP</li>
        <li>5 concurrent requests per IP</li>
    </ul>

    <h2>Behavior Notes</h2>

    <ul>
        <li>Stateless</li>
        <li>No authentication</li>
        <li>No guarantees on exact timing</li>
        <li>Designed for development and testing</li>
    </ul>

    <h2>Use Cases</h2>

    <ul>
        <li>Testing loading indicators and spinners</li>
        <li>Simulating slow or unreliable networks</li>
        <li>Retry and timeout behavior validation</li>
        <li>UX latency observation</li>
        <li>Lightweight resilience testing</li>
    </ul>

    <footer>
        <div><a href="/">← Home</a></div>
        <div><a href="https://github.com/awestarsolutions/daas" target="_blank">GitHub</a></div>
    </footer>

</div>
</body>
</html>
