<script setup>
import { Head, Link, Form ,usePage } from '@inertiajs/vue3';
import FolderLayout from '@/layouts/FolderLayout.vue';
import { show } from '@/routes/projects';
import ContactController from '@/actions/App/Http/Controllers/ContactController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Textarea } from '@/components/ui/textarea';

defineProps({
    projects: Array,
});

// --- À propos (carnet) ---
// Mets ici l'adresse de ta photo, par exemple '/images/maurine.jpg' (dans public/images)
const photo = null;

const tools = [
    { name: 'Laravel', color: '#ff5a4d', left: '6%', top: '-10%', rotate: -8 },
    { name: 'Vue 3', color: '#41b883', left: '33%', top: '-30%', rotate: 5 },
    { name: 'Inertia', color: '#9553e9', left: '60%', top: '-8%', rotate: 9 },
    { name: 'Tailwind', color: '#38bdf8', left: '38%', top: '10%', rotate: -4 },
];

// --- Accueil (hero) ---
const year = new Date().getFullYear();

// Les 4 coins « poignées » de la boîte de sélection
const handles = ['-left-2 -top-2', '-right-2 -top-2', '-left-2 -bottom-2', '-right-2 -bottom-2'];

// Chaque chiffre de l'année est légèrement décalé / incliné
const digitStyles = [
    'rotate(-8deg) translateY(4px)',
    'rotate(7deg) translateY(-4px)',
    'rotate(-5deg) translateY(3px)',
    'rotate(9deg) translateY(-3px)',
];

const page = usePage();

</script>

<template>
    <Head title="Accueil">
        <meta head-key="description" name="description" content="Portfolio de Maurine Meeus, Web Designer et Web Developer. Découvrez mes créations et mes derniers projets." />
    </Head>

    <!-- On utilise le Layout et on récupère l'onglet actif grâce à v-slot -->
    <FolderLayout mode="home" v-slot="{ activeTab }">

        <!-- 1. Contenu Accueil -->
        <div
            v-show="activeTab === 'accueil'"
            class="hero relative overflow-hidden rounded-[32px] px-4 pt-14 pb-32 md:pt-20 md:pb-28 min-h-[480px] md:min-h-[560px] flex items-start justify-center"
        >
            <!-- Fond dégradé flou (orange, rose, bleu) -->
            <div class="pointer-events-none absolute -left-24 top-1/3 h-72 w-72 rounded-full bg-[#ffb347] opacity-70 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -top-24 right-0 h-72 w-[26rem] rounded-full bg-[#f4a6cb] opacity-60 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-28 -right-16 h-72 w-72 rounded-full bg-[#b8c6f5] opacity-70 blur-3xl" aria-hidden="true"></div>

            <!-- Boîte de sélection + titre -->
            <div class="relative w-full max-w-2xl">
                <div class="relative border-2 border-dashed border-[#6b2d4f] px-6 pt-8 pb-14 md:px-12 md:pt-12 md:pb-20 -rotate-1">
                    <span
                        v-for="pos in handles"
                        :key="pos"
                        :class="['absolute h-4 w-4 bg-[#6b2d4f]', pos]"
                        aria-hidden="true"
                    ></span>

                    <h1 class="font-serif font-bold text-[#6b2d4f] leading-[0.85] tracking-tight text-left" aria-label="Portfolio">
                        <span aria-hidden="true" class="block text-7xl md:text-9xl">Port</span>
                        <span aria-hidden="true" class="block text-7xl md:text-9xl italic ml-16 md:ml-40">folio</span>
                    </h1>

                    <!-- Forme rose (blob) -->
                    <svg
                        class="float absolute right-6 top-6 w-14 md:right-14 md:top-8 md:w-20"
                        viewBox="0 0 100 100"
                        fill="#e87eb0"
                        aria-hidden="true"
                    >
                        <path d="M50 8c10-6 22 0 24 12 12 0 22 10 18 22-2 8-8 12-14 14 6 10 2 22-10 26-8 2-14-2-18-8-8 8-22 6-26-4-2-6 0-12 4-16C14 54 8 44 14 34c4-8 12-10 20-8 0-10 6-16 16-18z" />
                    </svg>

                    <!-- Astérisque bleu flou -->
                    <svg
                        class="float-slow absolute left-3 top-[58%] w-12 md:left-12 md:w-16 blur-[2px]"
                        viewBox="0 0 100 100"
                        fill="none"
                        stroke="#6f9bf0"
                        stroke-width="12"
                        stroke-linecap="round"
                        aria-hidden="true"
                    >
                        <path d="M50 8 V92 M14 28 L86 72 M86 28 L14 72" />
                    </svg>

                    <!-- Curseur orange -->
                    <svg
                        class="float absolute -right-3 top-[60%] w-9 md:-right-9 md:w-12 drop-shadow-sm"
                        viewBox="0 0 40 40"
                        fill="#ffb347"
                        stroke="#ffb347"
                        stroke-width="3"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M4 6 L34 18 L19 22 L14 36 Z" />
                    </svg>
                </div>

                <!-- Pastille sous-titre -->
                <div
                    class="absolute left-1/2 -bottom-6 -translate-x-1/2 whitespace-nowrap rounded-full bg-gradient-to-b from-[#f4a6cb] to-[#e07aa9] px-6 py-3 md:px-10 font-sans text-base md:text-2xl font-semibold text-white shadow-md"
                >
                    Design et Web developer
                </div>
            </div>

            <!-- Étiquette du nom -->
            <div class="absolute bottom-5 left-4 md:bottom-8 md:left-10 rounded-sm bg-[#d4e29a] px-4 py-2 font-sans text-xs md:text-sm text-[#4a3a2f]">
                Maurine Meeus
            </div>

            <!-- Année -->
            <div class="absolute bottom-4 right-5 md:bottom-7 md:right-14 flex font-sans font-black text-[#6b2d4f] text-3xl md:text-5xl" :aria-label="String(year)">
                <span
                    v-for="(digit, i) in String(year).split('')"
                    :key="i"
                    aria-hidden="true"
                    class="inline-block"
                    :style="{ transform: digitStyles[i % digitStyles.length] }"
                >
                    {{ digit }}
                </span>
            </div>
        </div>

        <!-- 2. Contenu À propos : un carnet posé sur la table -->
        <div v-show="activeTab === 'a-propos'">
            <h2 class="sr-only">À propos de moi</h2>

            <!-- La table (nappe vichy) -->
            <div class="gingham relative rounded-[28px] p-4 pb-8 md:p-10 md:pb-12">
                <!-- Stylo rose -->
                <div class="pointer-events-none absolute -left-1 top-8 z-30 hidden h-64 w-5 -rotate-6 md:block" aria-hidden="true">
                    <div class="h-16 rounded-t-full bg-white/60 border border-black/10"></div>
                    <div class="h-48 rounded-b-md bg-gradient-to-r from-[#f8b7cf] to-[#f08fb8] border border-black/10 shadow-md"></div>
                </div>

                <!-- Le carnet -->
                <div class="relative mx-auto max-w-5xl -rotate-1 drop-shadow-xl">
                    <div class="grid md:grid-cols-2 rounded-2xl overflow-hidden border border-[#efc9d8]">
                        <!-- Page de gauche -->
                        <section class="paper relative p-6 md:p-10 md:pr-12">
                            <span class="absolute left-6 top-4 -rotate-6 font-cursive text-xl text-[#d98aa8]">à propos de moi</span>

                            <p class="font-cursive text-6xl md:text-8xl leading-tight pt-6 bg-gradient-to-r from-[#7fa85a] via-[#d98aa8] to-[#a77b95] bg-clip-text text-transparent">
                                Bonjour !
                            </p>

                            <div class="mt-4 rounded-xl border border-[#f3a9c2] bg-[#fbd3e0] p-4 font-sans text-sm leading-relaxed">
                                Moi c'est <strong>Maurine</strong>, étudiante en développement web à l'IFOSUP Wavre.
                            </div>

                            <div class="mt-6 flex gap-4 items-start">
                                <!-- Photo collée au scotch -->
                                <div class="relative w-32 shrink-0 -rotate-3 md:w-40">
                                    <span class="tape -left-3 -top-2 -rotate-[35deg]" aria-hidden="true"></span>
                                    <span class="tape -right-3 -top-2 rotate-[35deg]" aria-hidden="true"></span>
                                    <div class="rounded-md border-2 border-dashed border-[#d9c3a5] bg-white p-2 shadow-md">
                                        <img v-if="photo" :src="photo" alt="Maurine Meeus" class="aspect-[3/4] w-full rounded-sm object-cover" />
                                        <div v-else class="flex aspect-[3/4] w-full items-center justify-center rounded-sm bg-gradient-to-br from-[#f8c6d9] via-[#ffe3a6] to-[#b8c6f5]" aria-hidden="true">
                                            <span class="font-cursive text-5xl text-white drop-shadow">MM</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p class="font-sans text-sm leading-relaxed text-[#5c7a3a]">
                                        Curieuse et créative, je serais ravie de mettre mes compétences au service de votre équipe !
                                    </p>

                                    <!-- Post-it contact -->
                                    <div class="sticky-note mt-5 rotate-2 bg-[#ffe66d] p-4 shadow-md">
                                        <p class="font-cursive text-3xl leading-none text-[#c97fa0]">Contacts</p>
                                        <p class="mt-2 font-sans text-xs leading-relaxed">
                                            Envie de collaborer ? Rendez-vous dans l'onglet <strong>Contact</strong> ↗
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Page de droite -->
                        <section class="paper relative p-6 md:p-10 md:pl-12 overflow-hidden">
                            <!-- Fleur décorative -->
                            <svg class="float absolute right-5 top-5 w-14 md:w-16" viewBox="0 0 100 100" aria-hidden="true">
                                <g fill="#f08fb8">
                                    <circle cx="50" cy="22" r="18" /><circle cx="78" cy="42" r="18" /><circle cx="68" cy="75" r="18" /><circle cx="32" cy="75" r="18" /><circle cx="22" cy="42" r="18" />
                                </g>
                                <circle cx="50" cy="52" r="10" fill="#ffe66d" />
                            </svg>

                            <p class="font-cursive text-5xl md:text-7xl leading-tight pt-2 bg-gradient-to-r from-[#d98aa8] to-[#7fa85a] bg-clip-text text-transparent">
                                Mes outils
                            </p>
                            <p class="font-cursive text-3xl md:text-4xl -mt-1 ml-10 text-[#a77b95]">&amp; compétences</p>

                            <!-- Étiquettes -->
                            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                                <span class="-rotate-6 rounded-full bg-[#8fb33a] px-5 py-1.5 font-cursive text-2xl text-white shadow-sm">Curieuse</span>
                                <span class="ribbon rotate-3 bg-[#f6a6c1] px-8 py-2 font-cursive text-2xl text-white">Créative</span>
                                <span class="-rotate-2 rounded-md border border-[#f3a9c2] bg-white/80 px-3 py-1 font-sans text-xs font-bold uppercase tracking-widest">Design</span>
                                <span class="rotate-2 rounded-md border border-[#d9c3a5] bg-white/80 px-3 py-1 font-sans text-xs font-bold uppercase tracking-widest">Web developer</span>
                            </div>

                            <!-- Enveloppe avec les outils -->
                            <div class="relative mx-auto mt-16 h-56 w-full max-w-sm">
                                <div class="envelope-flap absolute inset-x-0 -top-10 h-12 bg-[#f9d3e1]" aria-hidden="true"></div>
                                <div class="absolute inset-0 rounded-xl bg-[#f4b6cd]" aria-hidden="true"></div>

                                <div
                                    v-for="tool in tools"
                                    :key="tool.name"
                                    class="absolute z-10 flex h-[74px] w-[74px] flex-col items-center justify-center gap-1 rounded-xl bg-white shadow-md"
                                    :style="{ left: tool.left, top: tool.top, transform: `rotate(${tool.rotate}deg)` }"
                                >
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full font-sans text-sm font-black text-white" :style="{ backgroundColor: tool.color }">
                                        {{ tool.name.charAt(0) }}
                                    </span>
                                    <span class="font-sans text-[10px] font-bold">{{ tool.name }}</span>
                                </div>

                                <div class="envelope-front absolute inset-0 z-20 rounded-xl bg-gradient-to-b from-[#f8c6d9] to-[#f19cc3]" aria-hidden="true"></div>
                            </div>
                        </section>
                    </div>

                    <!-- Anneaux de la reliure (ordinateur) -->
                    <div class="pointer-events-none absolute inset-y-6 left-1/2 z-20 hidden -translate-x-1/2 flex-col justify-between md:flex" aria-hidden="true">
                        <span
                            v-for="n in 7"
                            :key="n"
                            class="block h-5 w-14 -translate-x-0 rounded-full border-[5px] bg-white/30 shadow-sm"
                            :class="n % 2 ? 'border-[#f2b6cc]' : 'border-[#e8e08a]'"
                        ></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Contenu Mes projets -->
        <div v-show="activeTab === 'mes-projets'">
            <h2 class="font-cursive text-5xl mb-10">Mes Projets</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(project, index) in projects" :key="project.slug" :class="['bg-white p-5 rounded-2xl shadow-md transition-all duration-300 border border-black/10 flex flex-col group', index % 2 === 0 ? 'rotate-1 hover:rotate-0 hover:-translate-y-2' : '-rotate-1 hover:rotate-0 hover:-translate-y-2']">
                    <div class="bg-gray-100 h-48 rounded-xl mb-5 overflow-hidden border border-black/5">
                        <img v-if="project.cover_url" :src="project.cover_url" :alt="project.title" width="1200" height="675" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-black/5 font-sans leading-relaxed text-lg max-w-2xl text-left">
                <p class="mb-4">Un projet en tête ? Envie de collaborer ? Écrivez-moi !</p>

                <!-- LE MESSAGE DE SUCCÈS -->
                <div v-if="page.props.toast" class="bg-[#99ffcc] border-2 border-black text-black font-bold p-4 rounded-xl mb-6 shadow-[2px_2px_0_rgba(0,0,0,1)] flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    {{ page.props.toast.message }}
                </div>

                <!-- LE MESSAGE D'ERREUR (si le formulaire est vide ou invalide) -->
                <div v-if="Object.keys(page.props.errors || {}).length > 0" class="bg-[#ffb3d9] border-2 border-black text-black font-bold p-4 rounded-xl mb-6 shadow-[2px_2px_0_rgba(0,0,0,1)] flex items-center gap-3">
                    <span class="text-2xl">❌</span>
                    Veuillez corriger les erreurs ci-dessous.
                </div>

                <Form v-bind="ContactController.store.form()" :reset-on-success="['name', 'email', 'message']" v-slot="{ errors, processing }" class="space-y-6 mt-6">

                    <div class="grid gap-2">
                        <Label for="name" class="font-bold">Nom</Label>
                        <Input id="name" name="name" autocomplete="name" class="border-black/20" />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email" class="font-bold">Adresse e-mail</Label>
                        <Input id="email" name="email" type="email" autocomplete="email" class="border-black/20" />
                        <InputError :message="errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="message" class="font-bold">Message</Label>
                        <Textarea id="message" name="message" rows="4" class="border-black/20" />
                        <InputError :message="errors.message" />
                    </div>
                    <Button type="submit" :disabled="processing" class="bg-black text-white font-bold py-6 px-8 rounded-full hover:bg-[#ff8000] transition-colors w-full text-lg">
                        <Spinner v-if="processing" class="mr-2" /> Envoyer le message
                    </Button>
                </Form>
            </div>
        </div>

    </FolderLayout>
</template>

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-8px) rotate(4deg);
    }
}

.float {
    animation: float 5s ease-in-out infinite;
}

.float-slow {
    animation: float 8s ease-in-out infinite reverse;
}

/* --- Page À propos : carnet --- */
.gingham {
    background-color: #eef7df;
    background-image:
        linear-gradient(90deg, rgba(150, 200, 110, 0.4) 50%, transparent 50%),
        linear-gradient(rgba(150, 200, 110, 0.4) 50%, transparent 50%);
    background-size: 44px 44px;
}

.paper {
    background-color: #fff9ef;
    background-image: radial-gradient(#ecd6cb 1px, transparent 1px);
    background-size: 14px 14px;
}

.tape {
    position: absolute;
    z-index: 5;
    width: 44px;
    height: 16px;
    background: rgba(255, 236, 150, 0.75);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
}

.sticky-note {
    clip-path: polygon(0 0, 100% 0, 100% 86%, 90% 100%, 0 100%);
}

.ribbon {
    clip-path: polygon(0 0, 100% 0, 94% 50%, 100% 100%, 0 100%, 6% 50%);
}

.envelope-flap {
    clip-path: polygon(0 100%, 50% 0, 100% 100%);
}

.envelope-front {
    clip-path: polygon(0 34%, 50% 62%, 100% 34%, 100% 100%, 0 100%);
}

@media (prefers-reduced-motion: reduce) {
    .float,
    .float-slow {
        animation: none;
    }
}
</style>
