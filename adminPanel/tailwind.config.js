/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'theme-primary': '#1e2139',
        'clr-primary': '#F8F8FB',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

