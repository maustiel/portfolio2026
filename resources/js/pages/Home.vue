<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { show } from '@/routes/projects';

defineProps({
    projects: Array,
});

const activeTab = ref('accueil');

// Réglages des intercalaires
// - color : couleur de l'onglet, de sa bande ET de la fiche (identique partout)
// - x     : position horizontale (% de la largeur du dossier)
const tabs = [
    { id: 'accueil', label: 'Accueil', x: 5, color: '#ffcce6' },
    { id: 'a-propos', label: 'À propos', x: 28, color: '#ffff99' },
    { id: 'mes-projets', label: 'Mes projets', x: 51, color: '#99ffcc' },
    { id: 'contact', label: 'Contact', x: 74, color: '#99ccff' },
];

// Pile des dossiers, du fond (index 0) jusqu'au devant (dernier index).
// L'onglet choisi passe devant ; les autres gardent leur ordre relatif.
const order = ref(['a-propos', 'contact', 'mes-projets', 'accueil']);

const rankOf = (tab) => order.value.indexOf(tab.id);

const select = (id) => {
    activeTab.value = id;
    order.value = [...order.value.filter((tabId) => tabId !== id), id];
};

const current = computed(() => tabs.find((t) => t.id === activeTab.value));

// Bande colorée située derrière chaque onglet
// Onglet survolé (hors onglet actif) : onglet + bande se soulèvent ensemble
const hovered = ref(null);
const isLifted = (tab) => hovered.value === tab.id && activeTab.value !== tab.id;

const stripStyle = (tab) => ({
    top: `calc(${rankOf(tab)} * var(--step) + var(--tab-h))`,
    // +8px : la bande se prolonge sous la suivante, pour qu'aucun vide n'apparaisse quand elle se soulève
    height: `calc((4 - ${rankOf(tab)}) * var(--step) + 8px)`,
    backgroundColor: tab.color,
    transform: isLifted(tab) ? 'translateY(-8px)' : 'none',
    zIndex: 1 + rankOf(tab),
});

// Onglet : court quand il est en retrait, il descend jusqu'à la fiche quand il est actif
const tabStyle = (tab) => {
    const isActive = tab.id === activeTab.value;
    const rank = rankOf(tab);
    return {
        left: `${tab.x}%`,
        top: `calc(${rank} * var(--step))`,
        height: isActive
            ? `calc(var(--zone) - ${rank} * var(--step) + 1px)`
            : 'calc(var(--tab-h) + 12px)',
        zIndex: isActive ? 20 : 1 + rank,
        '--c': tab.color,
        '--pad': isActive ? '0px' : '12px',
        transform: isLifted(tab) ? 'translateY(-8px)' : 'none',
    };
};
</script>

<template>
    <Head title="Portfolio" />

    <!-- LE FOND (grille rose clair, fixe pour couvrir tout l'écran) -->
    <div
        class="fixed inset-0 z-0"
        style="background-color: #ffffff; background-image: linear-gradient(#fadce6 1px, transparent 1px), linear-gradient(90deg, #fadce6 1px, transparent 1px); background-size: 50px 50px;"
    ></div>

    <!-- LE CONTENU PRINCIPAL -->
    <div class="max-w-6xl mx-auto pt-12 px-4 pb-20 relative z-10">
        <!-- LE DOSSIER -->
        <div class="folder relative mt-10 text-black">
            <!-- LES INTERCALAIRES -->
            <div class="relative" style="height: var(--zone)" role="tablist" aria-label="Sections du portfolio">
                <!-- Bandes colorées empilées derrière les onglets -->
                <div
                    v-for="tab in tabs"
                    :key="`strip-${tab.id}`"
                    class="strip"
                    :style="stripStyle(tab)"
                    aria-hidden="true"
                ></div>

                <!-- Onglets -->
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === tab.id"
                    :class="['tab', { 'is-active': activeTab === tab.id }]"
                    :style="tabStyle(tab)"
                    @click="select(tab.id)"
                    @mouseenter="hovered = tab.id"
                    @mouseleave="hovered = null"
                    @focus="hovered = tab.id"
                    @blur="hovered = null"
                >
                    <span class="tab-label">{{ tab.label }}</span>
                </button>
            </div>

            <!-- LA FICHE PRINCIPALE -->
            <main
                role="tabpanel"
                class="relative z-10 rounded-b-[40px] min-h-[560px] p-6 md:p-12 shadow-2xl transition-colors duration-500"
                :style="{ backgroundColor: current.color }"
            >
                <!-- 1. Contenu Accueil -->
                <div v-show="activeTab === 'accueil'" class="flex flex-col items-center justify-center h-full text-center space-y-6 pt-10 md:pt-16">
                    <h1 class="font-cursive text-6xl md:text-8xl text-black drop-shadow-[3px_3px_0_rgba(255,255,255,1)]">Design et Web developer</h1>
                    <h2 class="font-sans font-black text-5xl md:text-7xl text-[#ff8000] drop-shadow-[3px_3px_0_rgba(0,0,0,1)] tracking-tighter">PORTFOLIO</h2>

                    <div class="mt-12 bg-[#ffb3d9] border border-black px-8 py-3 rounded-full text-sm font-bold uppercase tracking-widest">
                        Maurine Meeus
                    </div>
                </div>

                <!-- 2. Contenu À propos -->
                <div v-show="activeTab === 'a-propos'">
                    <h2 class="font-cursive text-5xl mb-10">À propos de moi</h2>
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-black/5 font-sans leading-relaxed text-lg max-w-2xl">
                        <p>Étudiante en développement web à l'IFOSUP Wavre.</p>
                        <p class="mt-4">Curieuse et créative, je serais ravie de mettre mes compétences au service de votre équipe !</p>
                    </div>
                </div>

                <!-- 3. Contenu Mes projets -->
                <div v-show="activeTab === 'mes-projets'">
                    <h2 class="font-cursive text-5xl mb-10">Mes Projets</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div
                            v-for="(project, index) in projects"
                            :key="project.slug"
                            :class="[
                                'bg-white p-5 rounded-2xl shadow-md transition-all duration-300 border border-black/10 flex flex-col group',
                                index % 2 === 0 ? 'rotate-1 hover:rotate-0 hover:-translate-y-2' : '-rotate-1 hover:rotate-0 hover:-translate-y-2',
                            ]"
                        >
                            <div class="bg-gray-100 h-48 rounded-xl mb-5 overflow-hidden border border-black/5">
                                <img
                                    v-if="project.cover_url"
                                    :src="project.cover_url"
                                    :alt="project.title"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-gray-400 font-sans text-sm">Sans image</div>
                            </div>

                            <h3 class="font-bold text-xl mb-2">{{ project.title }}</h3>
                            <p class="text-sm text-gray-600 mb-6 font-sans flex-grow leading-relaxed">{{ project.summary }}</p>

                            <Link :href="show(project)" class="mt-auto block text-center bg-black text-white font-bold py-3 px-4 rounded-xl hover:bg-[#ff8000] hover:scale-[1.02] transition-all">
                                Ouvrir le dossier ↗
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- 4. Contenu Contact -->
                <div v-show="activeTab === 'contact'">
                    <h2 class="font-cursive text-5xl mb-10">Travaillons ensemble</h2>
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-black/5 font-sans leading-relaxed text-lg max-w-2xl">
                        <p class="mb-4">Un projet en tête ? Envie de collaborer ?</p>
                        <p class="text-gray-500 italic mb-8">Le formulaire de contact arrive bientôt (Chapitre 1.20)...</p>

                        <div class="inline-block bg-black text-white font-bold py-4 px-8 rounded-full rotate-2 hover:rotate-0 transition-transform cursor-pointer">
                            M'envoyer un message ↗
                        </div>
                    </div>
                </div>
            </main>

            <!-- Décorations (Étoile) -->
            <div class="absolute top-1/2 -right-16 z-50 transform rotate-12 pointer-events-none drop-shadow-md">
                <svg width="100" height="100" viewBox="0 0 100 100" fill="none" stroke="#ff8000" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"><path d="M50 10 L60 40 L90 50 L60 60 L50 90 L40 60 L10 50 L40 40 Z" /></svg>
            </div>
            <!-- Petite fleur en haut à gauche -->
            <div class="absolute -top-12 -left-8 z-50 transform -rotate-12 pointer-events-none drop-shadow-md">
                <svg width="80" height="80" viewBox="0 0 100 100" fill="#ff8000" stroke="black" stroke-width="4"><path d="M50 15 C 30 15, 20 35, 35 50 C 20 65, 40 85, 50 75 C 60 85, 80 65, 65 50 C 80 35, 70 15, 50 15" /></svg>
            </div>
        </div>
    </div>
</template>

<style scoped>
.folder {
    --tab-h: 46px; /* hauteur visible d'un onglet */
    --step: 24px; /* épaisseur visible de chaque bande */
    --zone: calc(var(--tab-h) + 4 * var(--step)); /* hauteur totale des intercalaires */
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

/* Bandes colorées derrière les onglets : elles comblent le vide jusqu'à la fiche */
.strip {
    position: absolute;
    left: 0;
    right: 0;
    border-radius: var(--sr) var(--sr) 0 0;
    transition:
        top 0.45s ease,
        height 0.45s ease,
        transform 0.25s ease,
        background-color 0.3s ease;
}

/* Onglet : sommet très arrondi, couleur pilotée par --c */
.tab {
    position: absolute;
    width: 21%;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    background-color: var(--c);
    border: 0;
    border-radius: 26px 26px 0 0;
    cursor: pointer;
    transition:
        top 0.45s ease,
        height 0.45s ease,
        transform 0.25s ease,
        background-color 0.3s ease;
}

/* Épaulements courbes à la base de l'onglet (effet intercalaire) */
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
    font-size: 9px;
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

.tab.is-active .tab-label {
    font-weight: 800;
}

.tab:focus-visible {
    outline: 3px solid #000;
    outline-offset: 2px;
}

@media (prefers-reduced-motion: reduce) {
    .tab,
    .strip {
        transition: none;
    }
}
</style>
