import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/User/**/*.php',
        './resources/views/filament/user/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                gray: {
                    DEFAULT: '#F5F5F5',
                },
                primary: {
                    DEFAULT: '#9D9067',
                },
            },
            backgroundImage: {
                logo: "url('/images/background.png')",
            }
        },
    },
}
