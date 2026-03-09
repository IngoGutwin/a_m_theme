import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath } from "node:url";

export default defineConfig(({ mode }) => ({
  publicDir: "public",
  base: mode === "development" ? "/" : "/wp-content/themes/a_m_theme/dist",
  css: {
    devSourcemap: true,
  },
  plugins: [
    vue(),
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
      timeout: 300000,
    },
    watch: {
      usePolling: true,
    },
    host: "0.0.0.0",
    port: 5173,
    strictPort: true,
  },
  build: {
    target: "es2020",
    cssCodeSplit: true,
    outDir: "dist",
    assetsDir: "",
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      input: {
        "base-js": fileURLToPath(new URL("/resources/app/base.ts", import.meta.url)),
        "appoinment-entry": fileURLToPath(
          new URL("/resources/app/appoinment.entry.ts", import.meta.url)
        ),
        "main-css": fileURLToPath(new URL("/resources/css/main.css", import.meta.url)),
      },
    },
  },
  resolve: {
    alias: {
      "@app": fileURLToPath(new URL("./resources/app", import.meta.url)),
      "@lib": fileURLToPath(new URL("./resources/lib", import.meta.url)),
    },
  },
}));
