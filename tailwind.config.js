/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/tallstackui/tallstackui/src/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
            },
        },
    },
    plugins: ["@tailwindcss/forms"],
    presets: [require("./vendor/tallstackui/tallstackui/tailwind.config.js")],
};
