/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
            colors: {
                'brand-primary': '#232C34',
                'brand-secondary': '#5A5A5A',
                'brand-background': '#F4F4F4',
            }
        }
  },
  plugins: [],
}

