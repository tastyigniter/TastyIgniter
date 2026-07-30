const path = require('path');
const fs = require('fs');

const pkg = process.argv[2];

let entry;

try {
    entry = require.resolve(pkg, { paths: [process.cwd()] });
} catch (e) {
    process.exit(1);
}

let dir = path.dirname(entry);

while (dir !== path.dirname(dir)) {
    const manifest = path.join(dir, 'package.json');

    if (fs.existsSync(manifest)) {
        try {
            const json = JSON.parse(fs.readFileSync(manifest, 'utf8'));

            if (json.name === pkg && json.version) {
                process.stdout.write(String(json.version));
                break;
            }
        } catch (e) {
            // Ignore unreadable manifests and keep walking up.
        }
    }

    dir = path.dirname(dir);
}
