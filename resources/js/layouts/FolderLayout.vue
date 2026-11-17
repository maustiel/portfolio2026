<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { legal } from '@/routes';

const props = defineProps({
    mode: {
        type: String,
        default: 'home' // 'home' (accueil) ou 'project' (fiche)
    }
});

const tabs = [
    { id: 'accueil', label: 'Accueil', x: 5, color: '#ffcce6' },
    { id: 'a-propos', label: 'À propos', x: 28, color: '#ffff99' },
    { id: 'mes-projets', label: 'Mes projets', x: 51, color: '#99ffcc' },
    { id: 'contact', label: 'Contact', x: 74, color: '#99ccff' },
];

const page = usePage();
const getTabFromUrl = () => {
    if (typeof window === 'undefined' || !page.url.includes('?')) return null;
    const params = new URLSearchParams(page.url.split('?')[1]);
    return params.get('tab');
};

const tabParam = getTabFromUrl();

// Si on est sur une fiche projet, on force 'mes-projets'. Sinon, on lit l'URL.
const initialTab = props.mode === 'project'
    ? 'mes-projets'
    : (tabParam && tabs.some(t => t.id === tabParam) ? tabParam : 'accueil');

const activeTab = ref(initialTab);

const order = ref(
    tabs.map(t => t.id).filter(id => id !== activeTab.value).concat(activeTab.value)
);

const rankOf = (tab) => order.value.indexOf(tab.id);
const current = computed(() => tabs.find((t) => t.id === activeTab.value) || tabs[0]);

const hovered = ref(null);
const isLifted = (tab) => hovered.value === tab.id && activeTab.value !== tab.id;

const selectTab = (id) => {
    if (props.mode === 'project') {
        if (id === 'mes-projets') return;
        activeTab.value = id;
        order.value = [...order.value.filter((tabId) => tabId !== id), id];
        setTimeout(() => { router.visit(`/?tab=${id}`); }, 450);
    } else {
        activeTab.value = id;
        order.value = [...order.value.filter((tabId) => tabId !== id), id];
        if (typeof window !== 'undefined') {
            window.history.replaceState({}, '', `/?tab=${id}`);
        }
    }
};

const stripStyle = (tab) => ({
    top: `calc(${rankOf(tab)} * var(--step) + var(--tab-h))`,
    height: `calc((4 - ${rankOf(tab)}) * var(--step) + 8px)`,
    backgroundColor: tab.color,
    transform: isLifted(tab) ? 'translateY(-8px)' : 'none',
    zIndex: 1 + rankOf(tab),
});

const tabStyle = (tab) => {
    const isActive = tab.id === activeTab.value;
    const rank = rankOf(tab);
    return {
        left: `${tab.x}%`,
        top: `calc(${rank} * var(--step))`,
        height: isActive ? `calc(var(--zone) - ${rank} * var(--step) + 1px)` : 'calc(var(--tab-h) + 12px)',
        zIndex: isActive ? 20 : 1 + rank,
        '--c': tab.color,
        '--pad': isActive ? '0px' : '12px',
        transform: isLifted(tab) ? 'translateY(-8px)' : 'none',
    };
};
</script>

<template>
    <div class="fixed inset-0 z-0" style="background-color: #ffffff; background-image: linear-gradient(#fadce6 1px, transparent 1px), linear-gradient(90deg, #fadce6 1px, transparent 1px); background-size: 50px 50px;"></div>

   <!-- On réduit pt-12 à pt-2 pour remonter le tout -->
    <div class="max-w-6xl mx-auto pt-4 px-4 pb-20 relative z-10">
        <!-- On retire le mt-10 pour coller le dossier plus haut -->
        <div class="folder relative text-black">


            <!-- Intercalaires -->
            <div class="relative" style="height: var(--zone)" role="tablist">
                <div v-for="tab in tabs" :key="`strip-${tab.id}`" class="strip" :style="stripStyle(tab)" aria-hidden="true"></div>

                <a v-for="tab in tabs" :key="tab.id" :href="props.mode === 'project' && tab.id === 'mes-projets' ? '#' : `/?tab=${tab.id}`" @click.prevent="selectTab(tab.id)" @mouseenter="hovered = tab.id" @mouseleave="hovered = null" @focus="hovered = tab.id" @blur="hovered = null" :class="['tab', 'tab-link', { 'is-active': activeTab === tab.id }]" :style="tabStyle(tab)">
                    <span class="tab-label">{{ tab.label }}</span>
                </a>
            </div>

            <!-- FICHE PRINCIPALE : On utilise "slot" pour envoyer l'onglet actif à l'intérieur -->
            <article class="relative z-10 rounded-b-[40px] min-h-[560px] p-6 md:p-12 shadow-2xl transition-colors duration-500" :style="{ backgroundColor: current.color }">
                <slot :activeTab="activeTab" />
            </article>

            <!-- Décorations -->
            <div class="absolute top-1/2 -right-12 z-50 transform rotate-12 pointer-events-none drop-shadow-md hidden md:block">
                <svg width="90" height="90" viewBox="0 0 100 100" fill="none" stroke="#ff8000" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"><path d="M50 10 L60 40 L90 50 L60 60 L50 90 L40 60 L10 50 L40 40 Z" /></svg>
            </div>
            <div class="absolute -top-12 -left-8 z-50 transform -rotate-12 pointer-events-none drop-shadow-md">
                <svg width="80" height="80" viewBox="0 0 100 100" fill="#ff8000" stroke="black" stroke-width="4"><path d="M50 15 C 30 15, 20 35, 35 50 C 20 65, 40 85, 50 75 C 60 85, 80 65, 65 50 C 80 35, 70 15, 50 15" /></svg>
            </div>
        </div>

        <footer class="mt-8 pb-4 text-center text-sm font-sans font-bold text-gray-500">
            © Maurine Meeus - <Link :href="legal()" class="hover:text-black underline">Mentions légales</Link>
        </footer>
    </div>
</template>

<style scoped>
.folder {
    --tab-h: 46px; --step: 24px; --zone: calc(var(--tab-h) + 4 * var(--step)); --sr: 12px; --r: 6px;
}
@media (min-width: 768px) { .folder { --tab-h: 60px; --step: 30px; --r: 14px; --sr: 24px; } }
.strip {
    position: absolute; left: 0; right: 0; border-radius: var(--sr) var(--sr) 0 0;
    transition: top 0.45s ease, height 0.45s ease, transform 0.25s ease, background-color 0.3s ease;
}
.tab {
    position: absolute; width: 21%; display: flex; align-items: flex-start; justify-content: center; background-color: var(--c); border: 0; border-radius: 26px 26px 0 0; text-decoration: none;
    transition: top 0.45s ease, height 0.45s ease, transform 0.25s ease, background-color 0.3s ease;
}
.tab::before, .tab::after { content: ''; position: absolute; bottom: var(--pad); width: var(--r); height: var(--r); pointer-events: none; }
.tab::before { left: calc(var(--r) * -1); background: radial-gradient(circle at 0 0, transparent calc(var(--r) - 0.5px), var(--c) var(--r)); }
.tab::after { right: calc(var(--r) * -1); background: radial-gradient(circle at 100% 0, transparent calc(var(--r) - 0.5px), var(--c) var(--r)); }
.tab-label {
    display: flex; align-items: center; justify-content: center; height: var(--tab-h); max-width: 100%; padding: 0 6px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-family: 'Poppins', sans-serif; font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.02em; color: #000;
}
@media (min-width: 768px) { .tab-label { font-size: 14px; letter-spacing: 0.06em; } }
.tab.is-active .tab-label { font-weight: 800; }
.tab-link { cursor: pointer; }
.tab-link:hover .tab-label { text-decoration: underline; text-underline-offset: 4px; }
.tab-link:focus-visible { outline: 3px solid #000; outline-offset: 2px; }
</style>
