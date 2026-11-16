<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes';
</script>

<template>
    <Head title="Mentions légales">
        <meta
            head-key="description"
            name="description"
            content="Éditeur, hébergeur et données personnelles du portfolio de Maurine Meeus."
        />
    </Head>

    <!-- LE FOND (grille) -->
    <div class="fixed inset-0 z-0" style="background-color: #ffffff; background-image: linear-gradient(#fadce6 1px, transparent 1px), linear-gradient(90deg, #fadce6 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="max-w-4xl mx-auto pt-12 px-4 pb-20 relative z-10">

        <Link :href="home()" class="inline-block bg-white text-black font-bold py-2 px-6 rounded-full border-2 border-black hover:bg-[#ffcce6] mb-8 transition-colors">
            ← Retour au portfolio
        </Link>

        <article class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-black/5 font-sans prose prose-lg max-w-none prose-headings:font-cursive prose-headings:font-normal prose-a:text-[#ff8000]">
            <h1 class="text-5xl md:text-6xl mb-8">Mentions légales</h1>

            <h2 class="text-3xl mt-8 mb-4">Éditeur du site</h2>
            <p>
                Maurine Meeus, étudiante à l'IFOSUP Wavre. <br>
                Contact : via l'onglet Contact de la page principale.
            </p>

            <h2 class="text-3xl mt-8 mb-4">Hébergeur</h2>
            <p>OVH SAS, 2 rue Kellermann, 59100 Roubaix, France.</p>

            <h2 class="text-3xl mt-8 mb-4">Données personnelles</h2>
            <p>
                Le formulaire de contact enregistre votre nom, votre adresse e-mail
                et votre message, pour vous répondre et pour rien d'autre. Ces données ne
                sont ni vendues ni transmises à des tiers. Écrivez-moi pour les faire effacer.
            </p>

            <h2 class="text-3xl mt-8 mb-4">Cookies</h2>
            <p>
                Ce site ne dépose aucun cookie de mesure d'audience ni de publicité.
                Il utilise seulement les cookies techniques nécessaires à son
                fonctionnement (session et protection des formulaires).
            </p>
        </article>
    </div>
</template>
