/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/app/**/*.{html,js,php}"],
  theme: {
    extend: {},
  },
  daisyui: {
    themes: ["light", "dark"],
  },
  plugins: [require("daisyui")],
};
