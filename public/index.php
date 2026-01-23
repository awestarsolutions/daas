<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delay as a Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #0e0e0e;
            --panel: #161616;
            --border: #2a2a2a;
            --text: #eaeaea;
            --muted: #9a9a9a;
            --success: #7fd1a6;
            --error: #e57373;
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
            max-width: 780px;
            margin: 0 auto;
            padding: 64px 24px;
        }

        h1 {
            font-size: 30px;
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 15px;
            color: var(--muted);
            margin-bottom: 12px;
        }

        .links {
            margin-bottom: 24px;
            font-size: 14px;
        }

        .links a {
            color: var(--muted);
            text-decoration: none;
            margin-right: 16px;
        }

        .links a:hover {
            color: var(--text);
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 24px;
            margin: 32px 0;
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
        }

        .explain {
            font-size: 14px;
            color: var(--muted);
        }

        .examples {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        button {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            border-color: var(--text);
        }

        .custom {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        input {
            background: #0b0b0b;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 8px 10px;
            border-radius: 6px;
            width: 140px;
            font-size: 14px;
            margin-right: 8px;
        }

        .result {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            font-size: 14px;
        }

        .status {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .success { color: var(--success); }
        .error { color: var(--error); }

        .row {
            margin: 4px 0;
            color: var(--muted);
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

        footer a {
            color: inherit;
            text-decoration: none;
            border-bottom: 1px solid transparent;
        }

        footer a:hover {
            border-color: #6f6f6f;
        }
    </style>
</head>
<body>
<div class="wrap">

    <h1>Delay as a Service</h1>
    <div class="subtitle">
        An HTTP endpoint that waits before responding.
    </div>

    <div class="links">
        <a href="/docs">Documentation</a>
    </div>

    <div class="panel">
        <p><strong>What it does</strong></p>
        <p class="explain">
            This API introduces a deliberate delay before returning a response.
        </p>

        <code>GET /delay</code>
        <p class="explain">
            Returns a response after a short, random delay.
        </p>

        <code>GET /delay?ms=1000</code>
        <p class="explain">
            Requests a specific delay in milliseconds. Timing is best-effort.
        </p>
    </div>

    <div class="panel">
        <p><strong>Try an example</strong></p>
        <p class="explain">
            These examples call the live API and show what happens.
        </p>

        <div class="examples">
            <button onclick="runTest('/delay')">Random delay</button>
            <button onclick="runTest('/delay?ms=500')">500 ms</button>
            <button onclick="runTest('/delay?ms=1500')">1500 ms</button>
        </div>

        <div class="custom">
            <p class="explain"><strong>Custom delay</strong></p>
            <p class="explain">
                Use this if you want a specific timing (100–5000 ms).
            </p>
            <input type="number" id="customMs" placeholder="e.g. 1200">
            <button onclick="runCustom()">Run</button>
        </div>

        <div class="result" id="result"></div>
    </div>

    <div class="panel">
        <p><strong>Why use this</strong></p>
        <p class="explain">
            • Test loading states and spinners<br>
            • Simulate slow or unreliable networks<br>
            • Verify retry and timeout behavior<br>
            • Observe real user-perceived latency
        </p>
    </div>

    <div class="panel">
        <p><strong>Notes</strong></p>
        <p class="explain">
            • Stateless<br>
            • Public<br>
            • No SLA<br>
            • Best-effort timing
        </p>
    </div>

    <footer>
        <div>Minimal infrastructure, intentionally.</div>
        <div>
            <a href="https://github.com/awestarsolutions/daas" target="_blank">GitHub</a>
        </div>
    </footer>

</div>

<script>
async function runTest(url) {
    const result = document.getElementById("result");
    result.innerHTML = "<div class='status'>Waiting…</div>";

    const start = performance.now();

    try {
        const res = await fetch(url);
        const data = await res.json();
        const elapsed = Math.round(performance.now() - start);

        result.innerHTML = `
            <div class="status success">Success</div>
            <div class="row">Endpoint: ${url}</div>
            <div class="row">Service delay: ${data.delay_ms} ms</div>
            <div class="row">Observed time: ${elapsed} ms</div>
        `;
    } catch (e) {
        result.innerHTML = `
            <div class="status error">Failed</div>
            <div class="row">The request did not complete.</div>
        `;
    }
}

function runCustom() {
    const ms = document.getElementById("customMs").value;
    if (!ms) return;
    runTest(`/delay?ms=${encodeURIComponent(ms)}`);
}
</script>

</body>
</html>
