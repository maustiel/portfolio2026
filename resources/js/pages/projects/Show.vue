<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FolderLayout from '@/layouts/FolderLayout.vue';

defineProps({
    project: Object,
});

const tagColors = ['#ffcce6', '#ffff99', '#ffd699', '#99ccff'];
</script>

<template>
    <Head :title="project.title" />

    <FolderLayout mode="project">

        <div class="mb-10">
            <Link href="/?tab=mes-projets" class="inline-block bg-white text-black font-bold py-3 px-6 rounded-full border-2 border-black hover:bg-[#ffcce6] hover:-translate-y-1 transition-all shadow-sm">
                ← Retour aux projets
            </Link>
        </div>

        <div class="grid gap-10 md:grid-cols-5 items-start">
            <div class="md:col-span-2">
                <div class="bg-white p-4 pb-10 rounded-2xl shadow-md border border-black/10 -rotate-2 hover:rotate-0 transition-transform duration-300">
                    <div class="bg-gray-100 aspect-[4/3] rounded-xl overflow-hidden border border-black/5">
                        <img v-if="project.cover_url" :src="project.cover_url" :alt="project.title" width="1200" height="675" class="w-full h-full object-cover" />
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400 font-sans text-sm">Sans image</div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3 space-y-6">
                <h1 class="font-cursive text-5xl md:text-7xl text-black leading-tight drop-shadow-[3px_3px_0_rgba(255,255,255,1)]">
                    {{ project.title }}
                </h1>
                <p class="font-sans text-lg leading-relaxed text-black/80">{{ project.summary }}</p>
                <ul v-if="project.tags && project.tags.length" class="flex flex-wrap gap-3">
                    <li v-for="(tag, index) in project.tags" :key="tag" class="font-sans font-bold text-xs uppercase tracking-widest border border-black rounded-full px-4 py-2" :style="{ backgroundColor: tagColors[index % tagColors.length] }">
                        {{ tag }}
                    </li>
                </ul>
                <div v-if="project.demo_url || project.repo_url" class="flex flex-wrap gap-4 pt-2">
                    <a v-if="project.demo_url" :href="project.demo_url" target="_blank" rel="noopener" class="bg-black text-white font-sans font-bold py-3 px-6 rounded-xl hover:bg-[#ff8000] hover:scale-[1.02] transition-all">Démo ↗</a>
                    <a v-if="project.repo_url" :href="project.repo_url" target="_blank" rel="noopener" class="bg-white text-black font-sans font-bold py-3 px-6 rounded-xl border-2 border-black hover:bg-[#ffff99] hover:scale-[1.02] transition-all">Code ↗</a>
                </div>
            </div>
        </div>

        <div v-if="project.content" class="mt-12 bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-black/5 font-sans prose prose-lg max-w-none prose-headings:font-cursive prose-headings:font-normal prose-a:text-[#ff8000] prose-img:rounded-2xl" v-html="project.content"></div>

    </FolderLayout>
</template>
