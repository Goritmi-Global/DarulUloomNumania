import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

export default defineConfig({
  server: {
    https: {
      key: fs.readFileSync('C:/xampp/apache/conf/ssl.key/server.key'),
      cert: fs.readFileSync('C:/xampp/apache/conf/ssl.crt/server.crt'),
    },
    host: 'localhost',
    port: 5173,
    cors: true,
    hmr: {
      protocol: 'wss',
      host: 'localhost',
    },
  },
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
});
