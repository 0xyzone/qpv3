import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [
                "app/Http/Livewire/**", // Custom Livewire components
                "app/Filament/**", // Filament Resources
            ],
        }),
        tailwindcss(),
    ],
});
