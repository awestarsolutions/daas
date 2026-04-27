# Delay as a Service

Delay as a Service (DaaS) is a minimal HTTP API that waits before responding.

It exists to make time a first-class dependency during development.

Modern applications rely on latency for:
- loading states
- retry behavior
- timeout handling
- user-perceived performance

Yet time is often mocked or skipped entirely.

DaaS does not simulate networks or failures.
It does not queue jobs or guarantee timing.
It simply waits.

This makes it useful for testing real-world delay behavior without additional infrastructure.

## Example

```bash
GET /delay
GET /delay?ms=1000
{
  "status": "ok",
  "delay_ms": 1000
}

there is a change in the repo for testing ourpose

