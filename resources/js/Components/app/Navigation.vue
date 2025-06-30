<template>
    <nav class="min-w-[200px]">
        <Link :href="route('myFiles')" class="h-[80px] px-3 flex items-center gap-3">
            <ApplicationLogo
                class="block h-9 w-auto fill-current text-gray-800"
            />
            <p class="font-bold text-xl text-green-800">TuxitVault</p>
        </Link>
        <div class="px-3">
            <CreateNewDropdown />

            <div class="py-3">
                <NavLink :href="route('myFiles')" :active="$page.url == '/my-files'">Mes fichiers</NavLink>
                <NavLink href="/">Partagé avec moi</NavLink>
                <NavLink href="/">Fichiers partagés par moi</NavLink>
                <NavLink :href="route('trash')" :active="$page.url == '/trash'">Poubelle</NavLink>
            </div>
        </div>
    </nav>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import CreateNewDropdown from "@/Components/app/CreateNewDropdown.vue";
import {Link} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
</script>
