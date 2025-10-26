import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "node:path";
import tailwindcss from "@tailwindcss/vite";
import { fileURLToPath } from "node:url";

export default defineConfig(({ mode }) => ({
  publicDir: "public",
  base: mode === "development" ? "/" : "/wp-content/themes/a_m_theme/",
  css: {
    devSourcemap: true,
  },
  plugins: [
    vue(),
    tailwindcss(),
    {
      name: "reload-php-server",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".php")) {
          server.ws.send({ type: "full-reload", path: "*" });
        }
      },
    },
  ],
  server: {
    proxy: {
      "/wp-content": {
        target: "http://a-m.test",
        changeOrigin: true,
      },
      "/wp-admin": {
        target: "http://a-m.test",
        changeOrigin: true,
      },
      "/wp-json": {
        target: "http://a-m.test",
        changeOrigin: true,
      },
    },
    cors: true,
    hmr: {
      host: "a-m.test",
      clientPort: 5173,
      protocol: "ws",
    },
    watch: {
      usePolling: true,
    },
    host: "0.0.0.0",
    port: 5173,
    strictPort: true,
  },
  build: {
    outDir: "dist",
    assetsDir: "assets",
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: fileURLToPath(new URL("/resources/app/index.ts", import.meta.url)),
      },
    },
  },
  resolve: {
    alias: {
      "@components": path.resolve(__dirname, "./resources/components"),
      "@images": path.resolve(
        __dirname,
        mode === "development" ? "./wp-content/uploads" : "../../uploads"
      ),
      "@styles": path.resolve(__dirname, "./resources/css"),
    },
  },
}));
