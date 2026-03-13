import forms from '@tailwindcss/forms';

export default {
    content: ['./resources/views/**/*.blade.php', './resources/js/**/*.js'],
    theme: {
        extend: {},
    },
    plugins: [forms],
};

