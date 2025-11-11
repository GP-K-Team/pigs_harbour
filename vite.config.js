import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import { readdirSync,lstatSync } from 'fs';
import { extname, resolve } from 'path';

const pageStyles = getFilesFromDir('./resources/css', ['.css']);
const js = getFilesFromDir('./resources/js',['.js']);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                ...pageStyles,
                'resources/js/app.js',
                ...js,
            ],
            refresh: true,
        }),
    ],
});

function getFilesFromDir(dir, fileTypes) {
    const filesToReturn = [];

    function walkDir(currentPath) {

        if(lstatSync(currentPath).isFile()){
            filesToReturn.push(currentPath);

            return;
        }

        const files = readdirSync(currentPath);

        for (let i in files) {
            const curFile = resolve(currentPath, files[i]);

            if (lstatSync(curFile).isDirectory()) {
                walkDir(curFile);

                continue;
            }

            if (fileTypes.includes(extname(curFile))) {
                filesToReturn.push(curFile);
            }
        }
    }

    walkDir(resolve(__dirname, dir));

    return filesToReturn;
}
