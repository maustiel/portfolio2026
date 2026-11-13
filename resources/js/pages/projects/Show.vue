<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes';

defineProps({
    project: Object,
});

// Couleurs des étiquettes (tags), en boucle
const tagColors = ['#ffcce6', '#ffff99', '#ffd699', '#99ccff'];
</script>

<template>
    <Head :title="project.title" />

    <!-- LE FOND (grille rose clair, fixe pour couvrir tout l'écran) -->
    <div
        class="fixed inset-0 z-0"
        style="background-color: #ffffff; background-image: linear-gradient(#fadce6 1px, transparent 1px), linear-gradient(90deg, #fadce6 1px, transparent 1px); background-size: 50px 50px;"
    ></div>

    <div class="max-w-5xl mx-auto pt-12 px-4 pb-20 relative z-10">
        <!-- LE DOSSIER -->
        <div class="folder relative mt-10 text-black">
            <!-- LES INTERCALAIRES -->
            <div class="relative" style="height: var(--zone)">
                <!-- Bandes colorées derrière -->
                <div class="strip" style="top: var(--tab-h); height: calc(2 * var(--step) + 8px); background-color: #ffcce6; z-index: 1" aria-hidden="true"></div>
                <div class="strip" style="top: calc(var(--step) + var(--tab-h)); height: calc(var(--step) + 8px); background-color: #ffff99; z-index: 2" aria-hidden="true"></div>

                <!-- Onglet décoratif (jaune) -->
                <span class="tab" style="left: 65%; top: var(--step); height: calc(var(--tab-h) + 12px); --c: #ffff99; --pad: 12px; z-index: 2">
                    <span class="tab-label">Dossier projet</span>
                </span>

                <!-- Onglet retour (menthe), relié à la fiche -->
                <Link
                    :href="home()"
                    class="tab tab-link"
                    style="left: 5%; top: calc(2 * var(--step)); height: calc(var(--tab-h) + 1px); --c: #99ffcc; --pad: 0px; z-index: 20"
                >
                    <span class="tab-label">← Mes projets</span>
                </Link>
            </div>

            <!-- LA FICHE PRINCIPALE -->
            <article class="relative z-10 rounded-b-[40px] bg-[#99ffcc] p-6 md:p-12 shadow-2xl">
                <div class="grid gap-10 md:grid-cols-5 items-start">
                    <!-- Image de couverture façon photo collée -->
                    <div class="md:col-span-2">
                        <div class="bg-white p-4 pb-10 rounded-2xl shadow-md border border-black/10 -rotate-2 hover:rotate-0 transition-transform duration-300">
                            <div class="bg-gray-100 aspect-[4/3] rounded-xl overflow-hidden border border-black/5">
                                <img
                                    v-if="project.cover_url"
                                    :src="project.cover_url"
                                    :alt="project.title"
                                    class="w-full h-full object-cover"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-gray-400 font-sans text-sm">Sans image</div>
                            </div>
                        </div>
                    </div>

                    <!-- Titre, résumé, tags, liens -->
                    <div class="md:col-span-3 space-y-6">
                        <h1 class="font-cursive text-5xl md:text-7xl text-black leading-tight drop-shadow-[3px_3px_0_rgba(255,255,255,1)]">
                            {{ project.title }}
                        </h1>

                        <p class="font-sans text-lg leading-relaxed text-black/80">{{ project.summary }}</p>

                        <ul v-if="project.tags && project.tags.length" class="flex flex-wrap gap-3">
                            <li
                                v-for="(tag, index) in project.tags"
                                :key="tag"
                                class="font-sans font-bold text-xs uppercase tracking-widest border border-black rounded-full px-4 py-2"
                                :style="{ backgroundColor: tagColors[index % tagColors.length] }"
                            >
                                {{ tag }}
                            </li>
                        </ul>

                        <div v-if="project.demo_url || project.repo_url" class="flex flex-wrap gap-4 pt-2">
                            <a
                                v-if="project.demo_url"
                                :href="project.demo_url"
                                target="_blank"
                                rel="noopener"
                                class="bg-black text-white font-sans font-bold py-3 px-6 rounded-xl hover:bg-[#ff8000] hover:scale-[1.02] transition-all"
                            >
                                Démo ↗
                            </a>
                            <a
                                v-if="project.repo_url"
                                :href="project.repo_url"
                                target="_blank"
                                rel="noopener"
                                class="bg-white text-black font-sans font-bold py-3 px-6 rounded-xl border-2 border-black hover:bg-[#ffff99] hover:scale-[1.02] transition-all"
                            >
                                Code ↗
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contenu détaillé -->
                <div
                    v-if="project.content"
                    class="mt-12 bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-black/5 font-sans prose prose-lg max-w-none prose-headings:font-cursive prose-headings:font-normal prose-a:text-[#ff8000] prose-img:rounded-2xl"
                    v-html="project.content"
                ></div>
            </article>

            <!-- Décorations -->
            <div class="absolute top-1/2 -right-12 z-50 transform rotate-12 pointer-events-none drop-shadow-md hidden md:block">
                <svg width="90" height="90" viewBox="0 0 100 100" fill="none" stroke="#ff8000" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"><path d="M50 10 L60 40 L90 50 L60 60 L50 90 L40 60 L10 50 L40 40 Z" /></svg>
            </div>
            <div class="absolute -top-12 -left-8 z-50 transform -rotate-12 pointer-events-none drop-shadow-md">
                <svg width="80" height="80" viewBox="0 0 100 100" fill="#ff8000" stroke="black" stroke-width="4"><path d="M50 15 C 30 15, 20 35, 35 50 C 20 65, 40 85, 50 75 C 60 85, 80 65, 65 50 C 80 35, 70 15, 50 15" /></svg>
            </div>
        </div>
    </div>
</template>

<style scoped>
.folder {
    --tab-h: 46px;
    --step: 24px;
    --zone: calc(var(--tab-h) + 2 * var(--step)); /* hauteur de la zone d'intercalaires */
    --sr: 12px; /* arrondi des coins des bandes */
    --r: 6px; /* rayon de l'épaulement à la base de l'onglet (petit sur mobile pour ne pas dépasser) */
}

@media (min-width: 768px) {
    .folder {
        --tab-h: 60px;
        --step: 30px;
        --r: 14px;
        --sr: 24px;
    }
}

.strip {
    position: absolute;
    left: 0;
    right: 0;
    border-radius: var(--sr) var(--sr) 0 0;
}

.tab {
    position: absolute;
    width: 30%;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    background-color: var(--c);
    border-radius: 26px 26px 0 0;
    text-decoration: none;
}

/* Épaulements courbes à la base de l'onglet */
.tab::before,
.tab::after {
    content: '';
    position: absolute;
    bottom: var(--pad);
    width: var(--r);
    height: var(--r);
    pointer-events: none;
}
.tab::before {
    left: calc(var(--r) * -1);
    background: radial-gradient(circle at 0 0, transparent calc(var(--r) - 0.5px), var(--c) var(--r));
}
.tab::after {
    right: calc(var(--r) * -1);
    background: radial-gradient(circle at 100% 0, transparent calc(var(--r) - 0.5px), var(--c) var(--r));
}

.tab-label {
    display: flex;
    align-items: center;
    justify-content: center;
    height: var(--tab-h);
    max-width: 100%;
    padding: 0 6px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    color: #000;
}

@media (min-width: 768px) {
    .tab-label {
        font-size: 14px;
        letter-spacing: 0.06em;
    }
}

/* L'onglet « retour » est un lien cliquable */
.tab-link {
    cursor: pointer;
}
.tab-link:hover .tab-label {
    text-decoration: underline;
    text-underline-offset: 4px;
}
.tab-link:focus-visible {
    outline: 3px solid #000;
    outline-offset: 2px;
}
</style>
