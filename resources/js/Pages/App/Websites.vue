<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import {Head, router} from '@inertiajs/vue3';
import {useStore} from "@/Composables/store.js";
import {ref} from "vue";

const userWebsites = ref(null)

const getUserWebsites = async () => {
    try {
        useStore().setIsLoading(true)
        const url = '/api/websites/list'
        const response = await axios.get(url)
        useStore().setIsLoading(false)
        userWebsites.value = response.data
    } catch (error) {
        useStore().setIsLoading(false)
        console.log(error)
    }
}
getUserWebsites()

const selectUserWebsite = (userWebsite) => {
    router.visit(route('website', {'id': userWebsite.id}));
}
</script>

<template>
    <Head v-bind:title="$t('My Websites')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('My Websites')"/>
        </template>

        <Box class="min-h-52">
            <div class="grid grid-cols-3 gap-4">
                <div class="text-xs font-bold uppercase text-center py-2 ">Name</div>
                <div class="text-xs font-bold uppercase text-center py-2 ">Url</div>
                <div class="text-xs font-bold uppercase text-center py-2 "></div>
            </div>
            <div v-for="userWebsite in userWebsites"
                 class="grid grid-cols-3 gap-4 [&:nth-child(even)]:bg-neutral hover:bg-accent/20 p-1">
                <div class="text-center">{{ userWebsite.website.name }}</div>
                <div class="text-center">{{ userWebsite.website.url }}</div>
                <div class="text-center">
                    <SecondaryButton @click="selectUserWebsite(userWebsite)">View</SecondaryButton>
                </div>
            </div>
        </Box>
    </AppLayout>
</template>

