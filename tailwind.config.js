/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './resources/**/*.{html,js,php,blade.php}',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,vue}',
    './app/Livewire/**/*.php',
    './app/View/Components/**/*.php',
  ],
  theme: {
    extend: {
      // ─── Design Token: Colours ───────────────────────────────────────
      colors: {
        // Surface
        'surface':                    '#f5faf8',
        'surface-dim':                '#d6dbd9',
        'surface-bright':             '#f5faf8',
        'surface-container-lowest':   '#ffffff',
        'surface-container-low':      '#f0f5f2',
        'surface-container':          '#eaefed',
        'surface-container-high':     '#e4e9e7',
        'surface-container-highest':  '#dee4e1',
        'surface-variant':            '#dee4e1',
        'surface-tint':               '#006a61',
        'surface-muted':              '#F8FAFC',

        // On-Surface
        'on-surface':                 '#171d1c',
        'on-surface-variant':         '#3d4947',
        'inverse-surface':            '#2c3130',
        'inverse-on-surface':         '#edf2f0',

        // Outline
        'outline':                    '#6d7a77',
        'outline-variant':            '#bcc9c6',
        'border-high-contrast':       '#CBD5E1',

        // Primary
        'primary':                    '#00685f',
        'on-primary':                 '#ffffff',
        'primary-container':          '#008378',
        'on-primary-container':       '#f4fffc',
        'inverse-primary':            '#6bd8cb',
        'primary-fixed':              '#89f5e7',
        'primary-fixed-dim':          '#6bd8cb',
        'on-primary-fixed':           '#00201d',
        'on-primary-fixed-variant':   '#005049',

        // Secondary
        'secondary':                  '#006399',
        'on-secondary':               '#ffffff',
        'secondary-container':        '#7bc2ff',
        'on-secondary-container':     '#004f7b',
        'secondary-fixed':            '#cde5ff',
        'secondary-fixed-dim':        '#94ccff',
        'on-secondary-fixed':         '#001d32',
        'on-secondary-fixed-variant': '#004b74',

        // Tertiary
        'tertiary':                   '#924628',
        'on-tertiary':                '#ffffff',
        'tertiary-container':         '#b05e3d',
        'on-tertiary-container':      '#fffbff',
        'tertiary-fixed':             '#ffdbce',
        'tertiary-fixed-dim':         '#ffb59a',
        'on-tertiary-fixed':          '#370e00',
        'on-tertiary-fixed-variant':  '#773215',

        // Error
        'error':                      '#ba1a1a',
        'on-error':                   '#ffffff',
        'error-container':            '#ffdad6',
        'on-error-container':         '#93000a',

        // Background
        'background':                 '#f5faf8',
        'on-background':              '#171d1c',

        // Status
        'status-normal':              '#16A34A',
        'status-warning':             '#D97706',
        'status-critical':            '#DC2626',
        'status-oversized':           '#7C3AED',
      },

      // ─── Design Token: Border Radius ─────────────────────────────────
      borderRadius: {
        'sm':      '0.25rem',
        'DEFAULT': '0.5rem',
        'md':      '0.75rem',
        'lg':      '1rem',
        'xl':      '1.5rem',
        'full':    '9999px',
      },

      // ─── Design Token: Spacing ───────────────────────────────────────
      spacing: {
        'base':         '8px',
        'touch-target': '48px',
        'gutter':       '24px',
        'margin-page':  '32px',
        'stack-sm':     '12px',
        'stack-md':     '24px',
        'stack-lg':     '40px',
      },

      // ─── Design Token: Font Family ───────────────────────────────────
      fontFamily: {
        sans:           ['Public Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        'display':      ['Public Sans', 'sans-serif'],
        'headline-lg':  ['Public Sans', 'sans-serif'],
        'headline-md':  ['Public Sans', 'sans-serif'],
        'body-lg':      ['Public Sans', 'sans-serif'],
        'body-md':      ['Public Sans', 'sans-serif'],
        'label-lg':     ['Public Sans', 'sans-serif'],
        'data-tabular': ['Public Sans', 'sans-serif'],
      },

      // ─── Design Token: Font Size ─────────────────────────────────────
      fontSize: {
        'display':      ['48px', { lineHeight: '1.2',  fontWeight: '700' }],
        'headline-lg':  ['32px', { lineHeight: '1.3',  fontWeight: '700' }],
        'headline-md':  ['24px', { lineHeight: '1.4',  fontWeight: '600' }],
        'body-lg':      ['18px', { lineHeight: '1.6',  fontWeight: '400' }],
        'body-md':      ['16px', { lineHeight: '1.6',  fontWeight: '400' }],
        'label-lg':     ['14px', { lineHeight: '1.2',  fontWeight: '600', letterSpacing: '0.02em' }],
        'data-tabular': ['16px', { lineHeight: '1.4',  fontWeight: '500' }],
      },
    },
  },
  plugins: [],
}
