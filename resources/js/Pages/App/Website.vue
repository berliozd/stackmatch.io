<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import {Head, router} from '@inertiajs/vue3';
import {reactive, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import {useStore} from "@/Composables/store.js";

const props = defineProps({id: null})
const id = window.location.href.split('/').pop();
const userWebsite = ref(null)

const form = reactive({
    historyContent: '',
})


if (!id) {
    router.visit(route('websites'));
}

const getUserWebsite = async () => {
    try {
        const url = '/api/user_website/' + id
        const response = await axios.get(url)
        userWebsite.value = response.data
    } catch (error) {
        console.log(error)
    }
}
getUserWebsite()

const submit = () => {
    axios.post('/api/histories/add', {'content': form.historyContent, 'user_website_id': id})
        .then(response => {
            useStore().setToast('Added!');
            getUserWebsite()
        })
        .catch(error => {
            console.error(error);
        });
}
</script>

<template>
    <Head v-bind:title="$t('Website')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('Website')"/>
        </template>
        <Box>
            <div class="text-center text-2xl font-bold mb-4 uppercase">Name : {{ userWebsite?.website.name }}</div>
            <div class="text-center">Url : {{ userWebsite?.website.url }}</div>
        </Box>
        <Box>
            <div v-if="userWebsite?.website.techs.length>0" class="underline mb-2">Used technologies</div>
            <div class="flex flex-row space-x-2">
                <div v-for="tech in userWebsite?.website.techs">{{ tech.tech.name }}</div>
            </div>
        </Box>
        <Box>
            <div v-if="userWebsite?.histories.length>0" class="underline mb-2">History</div>
            <div v-else>No history</div>
            <div v-for="history in userWebsite?.histories" class="mb-2">
                <div class="bg-neutral-content/40 border rounded p-2 mb-1">
                    {{ history?.content }}
                </div>
                <div class="text-xs text-neutral flex justify-end">Created at : {{ history?.created_at }}</div>
            </div>
        </Box>
        <Box>
            <div>Add new history</div>
            <form @submit.prevent="submit">
                <div class="mb-2">
                    <TextArea v-model="form.historyContent"/>
                </div>
                <PrimaryButton type="submit">Add</PrimaryButton>
            </form>
        </Box>
    </AppLayout>
</template>

