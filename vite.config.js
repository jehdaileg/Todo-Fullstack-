import { defineConfig } from "laravel-vite";
import vue from "@vitejs/plugin-vue";
import path from 'path';

export default defineConfig({

    resolve: {
        alias: {
            '~' : path.resolve(__dirname, 'resources/scripts')
        }
    }
})
	.withPlugin(vue);
