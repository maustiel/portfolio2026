<script setup>
import { Form, Head } from "@inertiajs/vue3";
import ProjectController from "@/actions/App/Http/Controllers/Admin/ProjectController";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import { Textarea } from "@/components/ui/textarea";
import { index, edit } from "@/routes/admin/projects";
import RichTextEditor from "@/components/RichTextEditor.vue";

defineOptions({
    // Le fil d'Ariane dynamique qui utilise les props
    layout: (pageProps) => ({
        breadcrumbs: [
            { title: "Projets", href: index() },
            { title: pageProps.project.title, href: edit(pageProps.project) },
        ],
    }),
});

defineProps({
    project: Object, // On reçoit le projet à modifier
    tags: Array,
});
</script>

<template>
    <Head :title="'Modifier ' + project.title" />

    <div class="max-w-2xl p-4">
        <h1 class="mb-6 text-xl font-semibold">Modifier le projet</h1>

        <Form
            v-bind="ProjectController.update.form(project)"
            v-slot="{ errors, processing, progress }"
            class="space-y-6"
            novalidate
        >
            <div class="grid gap-2">
                <Label for="title">Titre</Label>
                <!-- On utilise :default-value pour pré-remplir -->
                <Input id="title" name="title" :default-value="project.title" />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="summary">Résumé</Label>
                <Textarea
                    id="summary"
                    name="summary"
                    rows="3"
                    :default-value="project.summary"
                />
                <InputError :message="errors.summary" />
            </div>
            <div class="grid gap-2">
                <Label>Contenu</Label>
                <RichTextEditor
                    name="content"
                    label="Contenu du projet"
                    :default-value="project.content"
                />
                <InputError :message="errors.content" />
            </div>
            <div class="grid gap-2">
                <Label for="demo_url">Lien de la démo</Label>
                <Input
                    id="demo_url"
                    name="demo_url"
                    type="url"
                    :default-value="project.demo_url"
                />
                <InputError :message="errors.demo_url" />
            </div>

            <div class="grid gap-2">
                <Label for="repo_url">Lien du code</Label>
                <Input
                    id="repo_url"
                    name="repo_url"
                    type="url"
                    :default-value="project.repo_url"
                />
                <InputError :message="errors.repo_url" />
            </div>
            <div class="grid gap-2">
                <img
                    v-if="project.cover_url"
                    :src="project.cover_url"
                    alt=""
                    class="w-48 rounded"
                />
                <Label for="cover">Image de couverture</Label>
                <Input id="cover" name="cover" type="file" accept="image/*" />

                <progress
                    v-if="progress"
                    :value="progress.percentage"
                    max="100"
                    class="w-full"
                >
                    {{ progress.percentage }} %
                </progress>
                <InputError :message="errors.cover" />
            </div>
            <fieldset class="grid gap-2">
                <legend class="mb-2 text-sm font-medium">Technologies</legend>
                <Label
                    v-for="tag in tags"
                    :key="tag.id"
                    class="flex items-center gap-3"
                >
                    <!-- :default-value vérifie si l'ID du tag est dans la liste des tags du projet -->
                    <Checkbox
                        name="tags[]"
                        :value="String(tag.id)"
                        :default-value="project.tags.includes(tag.id)"
                    />
                    <span>{{ tag.name }}</span>
                </Label>
                <InputError :message="errors.tags" />
            </fieldset>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="processing">
                    <Spinner v-if="processing" />
                    Enregistrer
                </Button>
            </div>
        </Form>
    </div>
</template>
