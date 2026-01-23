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
            max-width: 760px;
            margin: 0 auto;
            padding: 64px 24px;
        }

        h1 {
            font-size: 30px;
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }

        .subtitle {
            margin-bottom: 32px;
            font-size: 15px;
            color: var(--muted);
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
        }

        .field {
            margin-top: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        input {
            width: 180px;
            background: #0b0b0b;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 14px;
        }

        .hint {
            font-size: 12px;
            color: #7a7a7a;
            margin-top: 6px;
        }

        button {
            margin-top: 16px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            border-color: var(--text);
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
    <div class="subtitle">An HTTP endpoint that waits before responding.</div>

    <div class="panel">
        <code>
GET /delay<br>
GET /delay?ms=1000
        </code>

        <div class="field">
            <label for="ms">Requested delay (milliseconds)</label>
            <input type="number" id="ms" placeholder="leave empty for random" min="100" max="5000">
            <div class="hint">
                Optional. If not provided, the service chooses a random delay.
            </div>
        </div>

        <button onclick="testDelay()">Run test</button>

        <div class="result" id="result"></div>
    </div>

    <p class="subtitle">
        No queues. No guarantees. Best-effort timing only.
    </p>

    <div class="panel">
        <p><strong>What this is for</strong></p>
        <p class="subtitle">
            Testing loading states, retry logic, and time-dependent behavior.<br>
            Making latency visible during development.
        </p>
    </div>

    <footer>
        <div>Stateless • Public • Minimal</div>
        <div>
            <a href="https://github.com/awestarsolutions/daas" target="_blank">GitHub</a>
        </div>
    </footer>
</div>

<script>
async function testDelay() {
    const result = document.getElementById("result");
    const ms = document.getElementById("ms").value;

    let url = "/delay";
    if (ms) url += "?ms=" + encodeURIComponent(ms);

    result.innerHTML = "<div class='status'>Waiting…</div>";

    const start = performance.now();

    try {
        const res = await fetch(url);
        const data = await res.json();
        const elapsed = Math.round(performance.now() - start);

        result.innerHTML = `
            <div class="status success">Success</div>
            <div class="row">Requested delay: ${ms || "random"}</div>
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
</script>
</body>
</html>
