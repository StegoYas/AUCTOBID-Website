import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                // Medieval Fantasy Theme Colors
                'medieval': {
                    'brown': '#8B4513',       // Saddle Brown - Primary (Wood/Leather)
                    'gold': '#D4AF37',         // Metallic Gold - Accents
                    'cream': '#FFF8DC',        // Cornsilk - Background (Parchment)
                    'slate': '#2F4F4F',        // Dark Slate Gray - Text/Iron
                    'dark-brown': '#5D2E0C',   // Deep Wood - Hover/Active
                    'light-gold': '#F4C430',   // Saffron - Highlights
                    'parchment': '#F5E6C8',    // Aged Paper
                    'bronze': '#CD7F32',       // Bronze - Secondary metallic
                    'copper': '#B87333',       // Copper - Tertiary metallic
                    'forest': '#228B22',       // Forest Green - Success/Nature
                    'crimson': '#800000',      // Crimson Red - Danger/Royal
                    'royal': '#002366',        // Royal Blue - Info/Magic
                    'stone': '#7d7d7d',        // Stone Gray - Neutral/Disabled
                },
            },
            fontFamily: {
                'cinzel': ['Cinzel', 'serif'],           // Headers, Titles
                'merriweather': ['Merriweather', 'serif'], // Body text
                'uncial': ['Uncial Antiqua', 'cursive'],   // Decorative fallback
                'sans': ['Merriweather', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'medieval': '0 4px 6px -1px rgba(139, 69, 19, 0.4), 0 2px 4px -1px rgba(139, 69, 19, 0.2)', // Deep brown shadow
                'gold': '0 0 15px rgba(212, 175, 55, 0.5)',     // Glowing gold aura
                'inner-parchment': 'inset 0 0 20px rgba(139, 69, 19, 0.1)', // Aged paper look
                'float': '0 10px 15px -3px rgba(47, 79, 79, 0.3)', // Floating element
            },
            backgroundImage: {
                'parchment-texture': "url('/images/parchment-bg.svg')",
                'wood-pattern': "linear-gradient(to bottom, #8B4513, #5D2E0C)", // Simple wood gradient fallback
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'pulse-gold': 'pulseGold 2s infinite',
                'float': 'float 3s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseGold: {
                    '0%, 100%': { boxShadow: '0 0 5px rgba(212, 175, 55, 0.4)' },
                    '50%': { boxShadow: '0 0 20px rgba(212, 175, 55, 0.8)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
