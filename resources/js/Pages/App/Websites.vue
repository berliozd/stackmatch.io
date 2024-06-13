<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {useStore} from "@/Composables/store.js";

const userWebsites = ref(null)
const selectedUserWebsite = ref(null)

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
    selectedUserWebsite.value = userWebsite
}
</script>

<template>
    <Head v-bind:title="$t('My stacks')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('My Websites')"/>
        </template>

        <Box class="min-h-52">
            <div v-for="userWebsite in userWebsites" @click="selectUserWebsite(userWebsite)"
                 class="inline-flex rounded-lg shadow-lg shadow-secondary-content/40 mr-1 mb-1 p-1 space-x-2 border hover:cursor-pointer">
                {{ userWebsite.website.name }}
            </div>
        </Box>

        <Box>
            <div>Name : {{ selectedUserWebsite?.website.name }}</div>
            <div>Url : {{ selectedUserWebsite?.website.url }}</div>

            <div>Technologies :</div>
            <ul v-for="tech in selectedUserWebsite?.website.techs" class=" list-disc">
                <li class=" ml-4 text-xs">{{ tech.tech.name }} - ({{ tech.tech.tech_tag.name }})</li>
            </ul>
        </Box>

    </AppLayout>
</template>

