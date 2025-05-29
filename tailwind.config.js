/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'), // Recommended for Filament
    require('@tailwindcss/typography'),
  ],
}

