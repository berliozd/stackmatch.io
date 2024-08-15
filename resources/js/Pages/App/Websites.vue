<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Ad from "@/Components/Ad.vue";
import DeleteButton from "@/Components/DeleteButton.vue";

import {Head, router, usePage} from '@inertiajs/vue3';
import {useStore} from "@/Composables/store.js";
import {ref} from "vue";
import goTo from "@/Composables/App/goTo.js";

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
        <Ad :el="'top'"/>
        <div class="w-full flex justify-center">
            <PrimaryButton @click="router.visit('websites-search')">Search websites</PrimaryButton>
        </div>
        <Box class="min-h-52">
            <template v-if="userWebsites?.length!=0">
                <div class="grid grid-cols-6">
                    <div class="text-xs font-bold uppercase py-2 col-span-3">Name</div>
                    <div class="text-xs font-bold uppercase py-2 col-span-2">Url</div>
                    <div class="text-xs font-bold uppercase py-2 "></div>
                </div>
                <div v-for="userWebsite in userWebsites"
                     class="grid grid-cols-6 [&:nth-child(even)]:bg-neutral-content hover:bg-accent/20 p-1 text-gray-500">
                    <div class="col-span-3 text-sm break-words hover:cursor-pointer"
                         @click="selectUserWebsite(userWebsite)">
                        {{ userWebsite.website.name }}
                    </div>
                    <div class="col-span-2 text-sm break-all hover:cursor-pointer"
                         @click="goTo('https://www.' + userWebsite.website.url, '_blank')">
                        {{ userWebsite.website.url }}
                    </div>
                    <div class="flex justify-end">
                        <DeleteButton @click="deleteUserWebsite(userWebsite)"></DeleteButton>
                    </div>
                </div>
            </template>
            <div v-if="userWebsites?.length==0"
                 class="my-4 h-32 rounded p-4 flex justify-center items-center border border-white/50 uppercase text-3xl">
                No websites so far...
            </div>
        </Box>
        <div class="w-full flex justify-center">
            <PrimaryButton @click="router.visit('websites-search')">Search websites</PrimaryButton>
        </div>
        <Ad :el="'bottom'"/>
        <DialogModal :show="displayingDelete" @close="displayingDelete = false">
            <template #content>
                <div class="">Are your sure you want to remove
                    <span class="font-bold text-accent">{{ selectedUserWebsite?.website.name }}</span>
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

