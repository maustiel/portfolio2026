<script setup>
import { Link } from '@inertiajs/vue3';
import { home } from '@/routes';
</script>

<template>
    <div class="mx-auto max-w-7xl px-4 relative z-50">
        <!-- On garde uniquement votre nom/logo pour pouvoir revenir à l'accueil
        <header class="py-6 mb-4">
            <Link :href="home()" class="font-cursive text-2xl font-bold text-black hover:text-[#ff8000] transition-colors">
                Maurine Meeus
            </Link>
        </header> -->

        <main>
            <slot />
        </main>

        <footer class="py-12 mt-12 text-sm opacity-50 text-center">
            © Maurine Meeus
        </footer>
    </div>
</template>
