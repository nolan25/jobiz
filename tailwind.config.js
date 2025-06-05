/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
    theme: {
        extend: {
            colors: {
                slate: {
                    700: "#A3A8A8",
                },
            },
        },
    },
    plugins: [],
};
