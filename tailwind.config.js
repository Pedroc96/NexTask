/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
      blue: {
          dark: '#1E40AF',
          DEFAULT: '#2563EB',
          light: '#60A5FA',
          skyblue: '#87CEEB',
        },
        greeen: {
          dark: '#003d57',
          DEFAULT: '#01b3a6',
          light: '#6EE7B7',
        },
        red: {
          dark: '#DC2626',
          DEFAULT: '#ef233c',
          light: '#FCA5A5',
          crayola: '#E84855',
          crayolaLight: '#f8c8cc',
        },
        alert: {
          dark: '#B91C1C',
          DEFAULT: '#d90429',
          light: '#FCA5A5',
        },
        warning: {
          DEFAULT: '#F59E0B',
          light: '#FCD34D',
        },
        neutral: {
          darkest: '#111827',
          dark: '#4B5563',
          DEFAULT: '#8d99ae',
          medium: '#edf2f4',
          mediumLight: '#e1e4e5',
          light: '#F3F4F6',
        },
        success: {
          DEFAULT: '#059669',
          light: '#34D399',
        },
        grey: {
          DEFAULT: '#93939f',
          lavander: '#E4E4EA',
         
        },
        extend: {
  
        },
      },
    },
  },
  plugins: [],
}

