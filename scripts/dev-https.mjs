import { spawn, spawnSync } from 'node:child_process';
import { existsSync, readFileSync } from 'node:fs';
import { createServer } from 'node:https';
import { request as httpRequest } from 'node:http';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const certificatePath = resolve(projectRoot, 'storage', 'app', 'dev-https', 'localhost.pfx');
const certificateScriptPath = resolve(projectRoot, 'scripts', 'dev-https-cert.ps1');
const httpsPort = 8000;
const laravelPort = 8001;

if (process.platform !== 'win32') {
    throw new Error('The trusted localhost certificate setup currently requires Windows.');
}

const certificateSetup = spawnSync(
    'powershell.exe',
    ['-NoProfile', '-ExecutionPolicy', 'Bypass', '-File', certificateScriptPath],
    { cwd: projectRoot, encoding: 'utf8', windowsHide: true },
);

if (certificateSetup.error) {
    throw certificateSetup.error;
}

if (certificateSetup.status !== 0) {
    process.stderr.write(certificateSetup.stderr ?? '');
    throw new Error('Could not create and trust the localhost HTTPS certificate.');
}

const certificatePassword = certificateSetup.stdout.trim();

if (!certificatePassword || !existsSync(certificatePath)) {
    throw new Error('Could not create and trust the localhost HTTPS certificate.');
}

const laravel = spawn(
    'php',
    ['artisan', 'serve', '--host=127.0.0.1', `--port=${laravelPort}`],
    { cwd: projectRoot, stdio: 'inherit', windowsHide: true },
);

let shuttingDown = false;

function stopLaravel() {
    if (!shuttingDown) {
        shuttingDown = true;
        laravel.kill();
    }
}

process.on('SIGINT', () => {
    server.close();
    stopLaravel();
});
process.on('SIGTERM', () => {
    server.close();
    stopLaravel();
});

const server = createServer(
    { pfx: readFileSync(certificatePath), passphrase: certificatePassword },
    (incoming, outgoing) => {
        const expectedHost = `localhost:${httpsPort}`;

        if (incoming.headers.host !== expectedHost) {
            outgoing.writeHead(400, { 'Content-Type': 'text/plain; charset=utf-8' });
            outgoing.end('Use https://localhost for this local development server.');

            return;
        }

        const headers = {
            ...incoming.headers,
            host: expectedHost,
            'x-forwarded-for': '127.0.0.1',
            'x-forwarded-host': expectedHost,
            'x-forwarded-port': String(httpsPort),
            'x-forwarded-proto': 'https',
        };

        for (const header of [
            'connection',
            'keep-alive',
            'proxy-authenticate',
            'proxy-authorization',
            'te',
            'trailer',
            'transfer-encoding',
            'upgrade',
        ]) {
            delete headers[header];
        }

        const upstream = httpRequest(
            {
                hostname: '127.0.0.1',
                port: laravelPort,
                path: incoming.url,
                method: incoming.method,
                headers,
            },
            (response) => {
                outgoing.writeHead(response.statusCode ?? 502, response.headers);
                response.pipe(outgoing);
            },
        );

        upstream.on('error', (error) => {
            console.error(`Could not reach Laravel on port ${laravelPort}: ${error.message}`);

            if (!outgoing.headersSent) {
                outgoing.writeHead(502, { 'Content-Type': 'text/plain; charset=utf-8' });
            }

            outgoing.end('The local Laravel server is unavailable.');
        });

        incoming.on('aborted', () => upstream.destroy());
        incoming.pipe(upstream);
    },
);

server.on('error', (error) => {
    console.error(`Could not start the local HTTPS server: ${error.message}`);
    stopLaravel();
    process.exitCode = 1;
});

server.listen(httpsPort, 'localhost', () => {
    console.log(`Survey app available at https://localhost:${httpsPort}`);
    console.log(`Laravel is proxied locally on port ${laravelPort}. Press Ctrl+C to stop.`);
});

laravel.on('error', (error) => {
    console.error(`Could not start Laravel: ${error.message}`);
    server.close();
    process.exitCode = 1;
});

laravel.on('exit', (code) => {
    if (!shuttingDown) {
        server.close();
        process.exitCode = code ?? 1;
    }
});
