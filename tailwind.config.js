const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                sans: ["Lexend Deca", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                pbtheme: {
                    primary: "#19743b",
                    secondary: "#16a34a",
                    info: "#3ABFF8",
                    success: "#36D399",
                    warning: "#FBBD23",
                    error: "#F87272",
                    green: "#19743b",
                    accent: "#806043",
                    neutral: "#3D4451",
                    "base-100": "#FFFFFF",
                },
                extend: {
                    colors: {
                        primary: "#19743b",
                        secondary: "#16a34a",
                        info: "#3ABFF8",
                        success: "#36D399",
                        warning: "#FBBD23",
                        error: "#F87272",
                        green: "#19743b",
                        red: "#F87272",
                        accent: "#806043",
                        neutral: "#3D4451",
                        "base-100": "#FFFFFF",
                    },
                },
            },
        ],
    },

    plugins: [
        require("daisyui"),
        require("flowbite/plugin"),
    ],
};
