module.exports = {
  content: [
    './resources/**/*.{html,js,php}',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        // Text Colors
        'primary-text': '#00BCD4',
        'secondary-text': '#4CAF50',
        'tertiary-text': '#7A7A7A',
        'accent-text': '#AAAAAA',

        // Grey Colors
        'grey-50': '#FFFFFF',
        'grey-100': '#F9F9F9',
        'grey-200': '#EAEFCO',
        'grey-300': '#D4DDEA',
        'grey-400': '#9A2B3',
        'grey-500': '#667085',
        'grey-600': '#745467',
        'grey-700': '#344054',
        'grey-800': '#1D2939',
        'grey-900': '#101828',

        // Primary Colors (Posyandu Kesehatan)
        'primary-50': '#E0F7FA',
        'primary-100': '#B2EBF2',
        'primary-200': '#80DEEA',
        'primary-300': '#4DD0E1',
        'primary-400': '#26C6DA',
        'primary-500': '#00BCD4',
        'primary-600': '#00ACC1',
        'primary-700': '#0097A7',
        'primary-800': '#00838F',
        'primary-900': '#006064',

        // Secondary Colors (Posyandu Kesehatan)
        'secondary-50': '#E8F5E9',
        'secondary-100': '#C8E6C9',
        'secondary-200': '#A5D6A7',
        'secondary-300': '#81C784',
        'secondary-400': '#66BB6A',
        'secondary-500': '#4CAF50',
        'secondary-600': '#43A047',
        'secondary-700': '#388E3C',
        'secondary-800': '#2C6D2F',
        'secondary-900': '#1B5E20',

        // Error Colors
        'error-100': '#FFF5F3',
        'error-200': '#FFBE5E',
        'error-300': '#FFDC1B',
        'error-400': '#FF5AC3',
        'error-500': '#EEDA8F',
        'error-600': '#F9887C',
        'error-700': '#F9624F',
        'error-800': '#D86324',
        'error-900': '#D0211E',

        // Success Colors
        'success-100': '#FFF5F3',
        'success-200': '#FFBE5E',
        'success-300': '#FFDC1B',
        'success-400': '#FF5AC3',
        'success-500': '#EEDA8F',
        'success-600': '#F9887C',
        'success-700': '#F9624F',
        'success-800': '#D86324',
        'success-900': '#D0211E',

        // Info Colors
        'info-100': '#FFF5F3',
        'info-200': '#FFBE5E',
        'info-300': '#FFDC1B',
        'info-400': '#FF5AC3',
        'info-500': '#EEDA8F',
        'info-600': '#F9887C',
        'info-700': '#F9624F',
        'info-800': '#D86324',
        'info-900': '#D0211E',
      },

      fontFamily: {
        primary: ['Roboto', 'sans-serif'],
        secondary: ['Arial', 'sans-serif'],
      },

      fontSize: {
        'overline-2': '10px',
        'overline-1': '12px',
        'caption-1': '12px',
        'caption-2': '14px',
        'body-2': '16px',
        'body-1': '18px',
        'heading-6': '20px',
        'heading-5': '24px',
        'heading-4': '28px',
        'heading-3': '32px',
        'heading-2': '38px',
        'heading-1': '48px',
        'display-2': '54px',
        'display-1': '72px',
      },

      lineHeight: {
        '140': '140%',
        '120': '120%',
      },

      fontWeight: {
        thin: 100,
        regular: 400,
        medium: 500,
        semibold: 600,
        bold: 700,
      },

      letterSpacing: {
        normal: '0',
        wide: '0.05em',
        wider: '0.1em',
      },

      screens: {
        desktop: '1200px',
        tablet: '768px',
        mobile: '480px',
      },
    },
  },
  plugins: [],
}
