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
            max-width: 720px;
            margin: 0 auto;
            padding: 64px 24px;
        }

        h1 {
            font-size: 30px;
            margin: 0 0 12px;
            letter-spacing: -0.02em;
        }

        p {
            margin: 0 0 16px;
            color: var(--muted);
            font-size: 15px;
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

        .controls {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        input {
            background: #0b0b0b;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 12px;
            border-radius: 6px;
            width: 120px;
        }

        button {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            border-color: var(--text);
        }

        .result {
            margin-top: 20px;
            font-size: 14px;
        }

        .success { color: var(--success); }
        .error { color: var(--error); }

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
    <p>An HTTP endpoint that waits before responding.</p>

    <div class="panel">
        <code>
GET /delay<br>
GET /delay?ms=1000
        </code>

        <div class="controls">
            <input type="number" id="ms" placeholder="ms (optional)" min="100" max="5000">
            <button onclick="testDelay()">Test delay</button>
        </div>

        <div class="result" id="result"></div>
    </div>

    <p>
        No queues. No guarantees.<br>
        Stateless. Best-effort timing.<br>
        It simply waits.
    </p>

    <div class="panel">
        <p><strong>Why does this exist?</strong></p>
        <p>
            To test loading states.<br>
            To simulate latency.<br>
            To make time explicit.
        </p>
    </div>

    <footer>
        <div>
            Best-effort timing. No SLA.
        </div>
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

    result.textContent = "Waiting…";
    result.className = "result";

    const start = performance.now();

    try {
        const res = await fetch(url);
        const data = await res.json();
        const elapsed = Math.round(performance.now() - start);

        result.innerHTML =
            `<span class="success">Success</span><br>` +
            `Requested: ${ms || "random"} ms<br>` +
            `Actual: ${data.delay_ms} ms<br>` +
            `Observed: ${elapsed} ms`;
    } catch (e) {
        result.innerHTML =
            `<span class="error">Failed</span><br>` +
            `The request did not complete.`;
    }
}
</script>
</body>
</html>
