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
      },
      keyframes: {
        'fade-in-down': {
          "from": {
            transform: "translateY(-0.75rem)",
            opacity: '0'
          },
          "to": {
            transform: "translateY(0rem)",
            opacity: '1'
          }
        }
      },
      animation: {
        'fade-in-down': "fade-in-down 0.2s ease-in-out both"
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

