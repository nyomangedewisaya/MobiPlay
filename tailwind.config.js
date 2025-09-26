/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
        fontFamily: {
            'inter': ['Inter', 'sans-serif'],
        },
    },
  },
  plugins: [],
}
