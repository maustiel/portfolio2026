<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { show } from '@/routes/projects'; // <-- Ajoutez cette ligne !

defineProps({
    projects: Array,
});

const activeTab = ref('accueil');
</script>

<template>
    <Head title="Designer Archives" />

    <div class="min-h-screen bg-white" style="background-image: linear-gradient(#f0e6eb 1px, transparent 1px), linear-gradient(90deg, #f0e6eb 1px, transparent 1px); background-size: 40px 40px;">

       <div class="max-w-6xl mx-auto pt-16 px-4 pb-20">


            <div class="relative mt-20">

                <!-- LES 4 ONGLETS (Navigation) -->
                <div class="flex flex-wrap -mb-[2px] relative z-10 px-4 space-x-[-15px]">

                    <!-- Onglet 1 : Accueil -->
                    <button
                        @click="activeTab = 'accueil'"
                        :class="[
                            'px-6 py-3 rounded-t-[20px] text-sm font-semibold transition-all shadow-sm border-t-2 border-l-2 border-r-2 border-black/5 uppercase',
                            activeTab === 'accueil' ? 'bg-[#ffcce6] z-40 pb-5 -mb-2' : 'bg-[#ffe6f2] z-30 hover:-translate-y-1'
                        ]">
                        Accueil
                    </button>

                    <!-- Onglet 2 : À propos -->
                    <button
                        @click="activeTab = 'a-propos'"
                        :class="[
                            'px-6 py-3 rounded-t-[20px] text-sm font-semibold transition-all shadow-sm border-t-2 border-l-2 border-r-2 border-black/5 uppercase',
                            activeTab === 'a-propos' ? 'bg-[#ff99cc] z-40 pb-5 -mb-2' : 'bg-[#ffb3d9] z-20 hover:-translate-y-1'
                        ]">
                        À propos
                    </button>

                    <!-- Onglet 3 : Mes projets -->
                    <button
                        @click="activeTab = 'mes-projets'"
                        :class="[
                            'px-6 py-3 rounded-t-[20px] text-sm font-semibold transition-all shadow-sm border-t-2 border-l-2 border-r-2 border-black/5 uppercase',
                            activeTab === 'mes-projets' ? 'bg-[#ffff99] z-40 pb-5 -mb-2' : 'bg-[#ffffb3] z-10 hover:-translate-y-1'
                        ]">
                        Mes projets
                    </button>

                    <!-- Onglet 4 : Contact -->
                    <button
                        @click="activeTab = 'contact'"
                        :class="[
                            'px-6 py-3 rounded-t-[20px] text-sm font-semibold transition-all shadow-sm border-t-2 border-l-2 border-r-2 border-black/5 uppercase',
                            activeTab === 'contact' ? 'bg-[#ffd699] z-40 pb-5 -mb-2' : 'bg-[#ffe6cc] z-0 hover:-translate-y-1'
                        ]">
                        Contact
                    </button>
                </div>

                <!-- LA FICHE PRINCIPALE -->
                <main
                    :class="[
                        'relative z-30 rounded-2xl rounded-tl-none shadow-xl border-2 border-black/5 min-h-[500px] p-10 transition-colors duration-300',
                        activeTab === 'accueil' ? 'bg-[#ffcce6]' : '',
                        activeTab === 'a-propos' ? 'bg-[#ff99cc]' : '',
                        activeTab === 'mes-projets' ? 'bg-[#ffff99]' : '',
                        activeTab === 'contact' ? 'bg-[#ffd699]' : ''
                    ]">

                    <!-- 1. Contenu Accueil -->
                    <div v-show="activeTab === 'accueil'" class="flex flex-col items-center justify-center h-full text-center space-y-4 pt-10">
                        <h1 class="font-cursive text-6xl md:text-8xl text-black drop-shadow-[4px_4px_0_rgba(255,255,255,1)]">Design et Web developer</h1>
                        <h2 class="font-sans font-bold text-5xl md:text-7xl text-[#ff8000] drop-shadow-[3px_3px_0_rgba(0,0,0,1)] tracking-tighter">PORTFOLIO</h2>

                        <div class="mt-8 bg-[#ffb3d9] border border-black/10 px-6 py-2 rounded-full text-sm font-bold uppercase">
                           Maurine Meeus
                        </div>
                    </div>

                    <!-- 2. Contenu À propos -->
                    <div v-show="activeTab === 'a-propos'">
                        <h2 class="font-cursive text-4xl mb-6">À propos de moi</h2>
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-black/5 font-sans leading-relaxed text-sm max-w-lg">
                            <p>Étudiante en développement web à l'IFOSUP Wavre.</p>
                            <p class="mt-4">Curieuse et créative, je serais ravie de mettre mes compétences au service de votre équipe !</p>
                        </div>
                    </div>

                  <!-- 3. Contenu Mes projets -->
                    <div v-show="activeTab === 'mes-projets'">
                        <h2 class="font-cursive text-4xl mb-8">Mes Projets</h2>

                        <!-- La grille avec la boucle sur vos vrais projets -->
                       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                            <div v-for="(project, index) in projects" :key="project.slug"
                                :class="[
                                    'bg-white p-4 rounded-xl shadow-md transition-all duration-300 border border-black/10 flex flex-col',
                                    index % 2 === 0 ? 'rotate-1 hover:rotate-0' : '-rotate-1 hover:rotate-0'
                                ]">

                                <!-- Image de couverture (façon Polaroid) -->
                                <div class="bg-gray-100 h-48 rounded-lg mb-4 overflow-hidden border border-black/5">
                                    <img v-if="project.cover_url" :src="project.cover_url" :alt="project.title" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center text-gray-400 font-sans text-sm">Sans image</div>
                                </div>

                                <!-- Textes -->
                                <h3 class="font-bold text-xl mb-1">{{ project.title }}</h3>
                                <p class="text-sm text-gray-600 mb-6 font-sans flex-grow leading-relaxed">{{ project.summary }}</p>

                                <!-- Bouton Inerita (Link) vers la fiche projet -->
                                <Link :href="show(project)" class="mt-auto block text-center bg-black text-white font-bold py-3 px-4 rounded-lg hover:bg-[#ff8000] hover:scale-[1.02] transition-all">
                                    Ouvrir le dossier ↗
                                </Link>

                            </div>

                        </div>
                    </div>

                    <!-- 4. Contenu Contact -->
                    <div v-show="activeTab === 'contact'">
                        <h2 class="font-cursive text-4xl mb-6">Travaillons ensemble</h2>
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-black/5 font-sans leading-relaxed text-sm max-w-lg">
                            <p class="mb-4">Un projet en tête ? Envie de collaborer ?</p>
                            <p class="text-gray-500 italic">Le formulaire de contact arrive bientôt (Chapitre 1.20)...</p>

                            <!-- Faux bouton stylisé -->
                            <div class="mt-6 inline-block bg-black text-white font-bold py-3 px-6 rounded-full rotate-2">
                                M'envoyer un message ↗
                            </div>
                        </div>
                    </div>

                </main>

                <!-- Décorations SVG (Étoile et fleur) -->
                <div class="absolute -top-10 -left-6 z-50 transform -rotate-12 pointer-events-none">
                    <svg width="60" height="60" viewBox="0 0 100 100" fill="#ff8000" stroke="black" stroke-width="4"><path d="M50 10 C 20 10, 10 30, 25 50 C 10 70, 30 90, 50 75 C 70 90, 90 70, 75 50 C 90 30, 80 10, 50 10" /></svg>
                </div>
                <div class="absolute top-1/2 -right-12 z-50 transform rotate-12 pointer-events-none">
                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none" stroke="#ff8000" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"><path d="M50 10 L60 40 L90 50 L60 60 L50 90 L40 60 L10 50 L40 40 Z" /></svg>
                </div>

            </div>
        </div>
    </div>
</template>
