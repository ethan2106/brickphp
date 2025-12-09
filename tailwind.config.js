/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./src/View/**/*.php",
        "./src/View/**/*.twig",
        "./resources/js/**/*.js",
        "./public/**/*.html"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
