const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
	mode: 'jit',
	purge: [
		'./resources/**/*.blade.php',
		'./resources/**/*.{js,ts,vue}',
	],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
