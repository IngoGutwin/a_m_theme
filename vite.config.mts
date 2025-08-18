import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "node:path";
import tailwindcss from "@tailwindcss/vite";
import { fileURLToPath } from "node:url";

export default defineConfig(({ mode }) => ({
  publicDir: "public",
  base: "",
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
      protocol: 'ws'
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
        main: fileURLToPath(
          new URL("/resources/app/index.ts", import.meta.url)
        ),
        // "pregnant-shooting": "/resources/ts/pregnant-shooting.ts",
        // "baby-shooting": "/resources/ts/pages/baby-shooting-page.ts",
        // "family-shooting": "/resources/ts/family-shooting.ts",
        // "wedding-shooting": "/resources/ts/wedding-shooting.ts",
        // "blog-index": "/resources/ts/blog-index.ts",
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
      "@styles": path.resolve(__dirname, "./resources/css")
    },
  },
}));
