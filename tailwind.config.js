import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                // Medieval Fantasy Theme Colors
                'medieval': {
                    'brown': '#8B4513',       // Saddle Brown - Primary
                    'gold': '#D4AF37',         // Gold - Secondary/Accent
                    'cream': '#FFF8DC',        // Cornsilk - Background
                    'slate': '#2F4F4F',        // Dark Slate Gray - Text
                    'dark-brown': '#5D2E0C',   // Darker brown for hover
                    'light-gold': '#E8C547',   // Lighter gold
                    'parchment': '#F5E6C8',    // Parchment color
                    'bronze': '#CD7F32',       // Bronze accent
                    'copper': '#B87333',       // Copper accent
                },
            },
            fontFamily: {
                'cinzel': ['Cinzel', 'serif'],
                'merriweather': ['Merriweather', 'serif'],
                'sans': ['Merriweather', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'medieval': '0 4px 6px -1px rgba(139, 69, 19, 0.3), 0 2px 4px -1px rgba(139, 69, 19, 0.2)',
                'gold': '0 4px 14px 0 rgba(212, 175, 55, 0.39)',
            },
            backgroundImage: {
                'parchment-texture': "url('/images/parchment-bg.png')",
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
