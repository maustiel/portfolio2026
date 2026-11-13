<script setup>
import { Head, Link, Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

import { create, index } from '@/routes/admin/projects';
import ProjectController from '@/actions/App/Http/Controllers/Admin/ProjectController';

import { Badge } from '@/components/ui/badge';

import { ArrowDown, ArrowUp } from '@lucide/vue';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Projets', href: index() }],
    },
});

defineProps({
    projects: Array,
});
</script>

<template>
    <Head title="Projets" />

    <div class="space-y-4 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Projets</h1>
            <Button as-child>
                <Link :href="create()">Nouveau projet</Link>
            </Button>
        </div>

        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Ordre</TableHead>
                    <TableHead>Titre</TableHead>
                    <TableHead>Adresse</TableHead>
                    <TableHead>État</TableHead>
                    <TableHead class="text-right">Actions</TableHead>

                </TableRow>
            </TableHeader>
            <TableBody>
               <TableRow v-for="(project, position) in projects" :key="project.id">
<TableCell class="flex gap-1">
                     <Form v-bind="ProjectController.moveUp.form(project)">
                         <Button
                             type="submit"
                             variant="ghost"
                             size="icon-sm"
                             aria-label="Monter"
                             :disabled="position === 0"
                         >
                             <ArrowUp class="w-4 h-4" />
                         </Button>
                     </Form>
                     <Form v-bind="ProjectController.moveDown.form(project)">
                         <Button
                             type="submit"
                             variant="ghost"
                             size="icon-sm"
                             aria-label="Descendre"
                             :disabled="position === projects.length - 1"
                         >
                             <ArrowDown class="w-4 h-4" />
                         </Button>
                     </Form>
                 </TableCell>
                    <!-- 1. On remet la cellule du Titre -->
                    <TableCell class="font-medium">{{ project.title }}</TableCell>

                    <!-- 2. On remet la cellule de l'Adresse -->
                    <TableCell>/projets/{{ project.slug }}</TableCell>


                    <TableCell>
                     <Badge v-if="project.published_at">Publié</Badge>
                     <Badge v-else variant="secondary">Brouillon</Badge>
                 </TableCell>

                    <!-- 3. La cellule des Actions -->
                    <TableCell class="text-right">
                        <!-- On utilise une div pour le flex, pas la cellule directement -->
                        <div class="flex justify-end gap-2">


                            <!-- Formulaire pour Publier / Dépublier -->
                     <Form
                         v-bind="ProjectController.togglePublished.form(project)"
                         class="inline"
                     >
                         <Button type="submit" variant="outline" size="sm">
                             {{ project.published_at ? 'Dépublier' : 'Publier' }}
                         </Button>
                     </Form>

                            <!-- Le bouton Modifier -->
                            <Button variant="outline" size="sm" as-child>
                                <Link :href="ProjectController.edit.url(project)">Modifier</Link>
                            </Button>

                            <!-- La boîte de dialogue pour Supprimer -->
                            <Dialog>
                                <DialogTrigger as-child>
                                    <Button variant="destructive" size="sm">Supprimer</Button>
                                </DialogTrigger>

                                <DialogContent>
                                    <DialogHeader>
                                        <DialogTitle>Supprimer ce projet ?</DialogTitle>
                                        <DialogDescription>
                                            Êtes-vous sûr de vouloir supprimer le projet "{{ project.title }}" ? Cette action est irréversible.
                                        </DialogDescription>
                                    </DialogHeader>

                                    <!-- Le formulaire qui envoie la requête DELETE -->
                                    <Form v-bind="ProjectController.destroy.form(project)">
                                        <DialogFooter>
                                            <DialogClose as-child>
                                                <Button type="button" variant="secondary">Annuler</Button>
                                            </DialogClose>
                                            <Button type="submit" variant="destructive">
                                                Confirmer la suppression
                                            </Button>
                                        </DialogFooter>
                                    </Form>
                                </DialogContent>
                            </Dialog>

                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
