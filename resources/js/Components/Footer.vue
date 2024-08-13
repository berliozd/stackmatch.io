<script setup>
import {router, usePage} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const isActive = (route) => {
    return location.href === route;
}

const appHomeRoute = route(usePage().props.app.home_route);
</script>
<template>
    <div class="btm-nav">
        <ApplicationLogo v-bind:simple="true"></ApplicationLogo>
        <a v-bind:href="appHomeRoute"
           v-bind:class="isActive(appHomeRoute)?'active':''">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-list">
                <line x1="8" x2="21" y1="6" y2="6"/>
                <line x1="8" x2="21" y1="12" y2="12"/>
                <line x1="8" x2="21" y1="18" y2="18"/>
                <line x1="3" x2="3.01" y1="6" y2="6"/>
                <line x1="3" x2="3.01" y1="12" y2="12"/>
                <line x1="3" x2="3.01" y1="18" y2="18"/>
            </svg>
        </a>
        <button @click="router.visit(route('dashboard'))" v-bind:class="isActive(route('dashboard'))?'active':''">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-layout-dashboard">
                <rect width="7" height="9" x="3" y="3" rx="1"/>
                <rect width="7" height="5" x="14" y="3" rx="1"/>
                <rect width="7" height="9" x="14" y="12" rx="1"/>
                <rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
        </button>
        <button @click="router.visit(route('profile.show'))" v-bind:class="isActive(route('profile.show'))?'active':''">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-circle-user-round">
                <path d="M18 20a6 6 0 0 0-12 0"/>
                <circle cx="12" cy="10" r="4"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>
        </button>
    </div>
</template>
