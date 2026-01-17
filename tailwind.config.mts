import type { Config } from "tailwindcss";

export default {
  content: [
    "./resources/app/components/**/*.vue",
    "./resources/css/*.css",
    "./index.php",
    "./parts/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        creme: "#f4efe5",
        blue: "#395968",
        black: "#0b1111",
        white: "#fdfcf7",
        brown: "#a97150",
      },
      fontFamily: {
        "lato-regular": ["Lato Regular", "sans-serif"],
        "lato-bold": ["Lato Bold", "sans-serif"],
      },
      gridTemplateColumns: {
        "shootings-grid": "repeat(auto-fill, minmax(8rem, 1fr))",
      },
    },
  },
  plugins: [],
} satisfies Config;
