import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import animate from 'tailwindcss-animate';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['class'],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                }
            },
            fontFamily: {
                sans: ['var(--font-sans)', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: 'rgb(var(--color-primary) / <alpha-value>)',
                accent: 'rgb(var(--color-accent) / <alpha-value>)',
                hover: 'rgb(var(--color-hover) / <alpha-value>)',
                dark: 'rgb(var(--color-dark) / <alpha-value>)',
                light: 'rgb(var(--color-light) / <alpha-value>)',
                border: 'rgb(var(--color-border) / <alpha-value>)',
                text: 'rgb(var(--color-text) / <alpha-value>)',
                card: 'rgb(var(--color-card) / <alpha-value>)',
                background: 'rgb(var(--color-background) / <alpha-value>)',
            },
            aspectRatio: {
                frame: '4 / 3',
            },
            brightness: {
                darken: 0.95,
            },
            minHeight: {
                layout: '80vh',
            },
            width: {
                half: '50vw',
            }
        },
    },

    plugins: [forms, typography, animate],
};
