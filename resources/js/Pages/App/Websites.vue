<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import {Head, router, usePage} from '@inertiajs/vue3';
import {useStore} from "@/Composables/store.js";
import {ref} from "vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const userWebsites = ref(null)
const selectedUserWebsite = ref(null)
const displayingDelete = ref(false)

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
const deleteUserWebsite = (userWebsite) => {
    selectedUserWebsite.value = userWebsite;
    displayingDelete.value = true;
}
const confirmDeleteUserWebsite = async (userWebsite) => {
    try {
        useStore().setIsLoading(true)
        axios.delete('/api/user_website/' + userWebsite.id)
            .then(response => {
                useStore().setToast('Deleted!');
                useStore().setIsLoading(false)
                getUserWebsites()
            })
            .catch(error => {
                console.error(error);
                usePage().props.error = error
            });

    } catch (error) {
        useStore().setIsLoading(false)
        console.log(error)
    } finally {
        displayingDelete.value = false;
    }
}
</script>

<template>
    <Head v-bind:title="$t('Websites')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('Websites')"/>
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
                <div class="text-center items-center flex flex-col md:flex-row space-y-1 space-x-2 justify-end">
                    <PrimaryButton @click="selectUserWebsite(userWebsite)">View</PrimaryButton>
                    <SecondaryButton @click="deleteUserWebsite(userWebsite)">Delete</SecondaryButton>
                </div>
            </div>
        </Box>
        <DialogModal :show="displayingDelete" @close="displayingDelete = false">
            <template #content>
                <div class="">Are your sure you want to remove
                    <span class="font-bold text-accent">{{selectedUserWebsite?.website.name }}</span>
                    from your website list?
                </div>
            </template>
            <template #footer>
                <div class="space-x-2">
                <PrimaryButton @click="confirmDeleteUserWebsite(selectedUserWebsite)">Delete</PrimaryButton>
                <SecondaryButton @click="displayingDelete = false">
                    Close
                </SecondaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

