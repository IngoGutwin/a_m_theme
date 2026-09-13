import type { Config } from "tailwindcss";

export default {
  content: [
    "./resources/app/**/*.{ts,js}",
    "./resources/css/*.css",
    "./index.php",
    "./page-*.php",
    "./parts/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        creme: "rgb(var(--color-creme))",
        black: "rgb(var(--color-black))",
      },
      fontFamily: {
        "lato-regular": ["Lato Regular", "sans-serif"],
        "lato-bold": ["Lato Bold", "sans-serif"],
      },
      gridTemplateColumns: {
        "shootings-grid": "repeat(auto-fill, minmax(8rem, 1fr))",
      },
      gridTemplateRows: {
        "view-ui": "1fr 100px",
      },
    },
  },
  plugins: [],
} satisfies Config;
