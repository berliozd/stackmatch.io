<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ErrorAlert from "@/Components/ErrorAlert.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import TextArea from "@/Components/TextArea.vue";

import {Head, router, usePage} from '@inertiajs/vue3';
import {reactive, ref} from "vue";
import {useStore} from "@/Composables/store.js";
import {askContactEmailContent} from "@/Composables/reallyAskAi.js";
import {Clipboard} from 'v-clipboard'

const props = defineProps({id: null})
const id = window.location.href.split('/').pop();
const userWebsite = ref(null)
const isEmailModalOpen = ref(false);
const emailTemplate = ref('')
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
    if (!validate(form)) {
        return;
    }
    axios.post('/api/histories/add', {'content': form.historyContent, 'user_website_id': id})
        .then(response => {
            useStore().setToast('Added!');
            getUserWebsite()
        })
        .catch(error => {
            console.error(error);
            usePage().props.error = error
        });
}
const validate = (form) => {
    usePage().props.error = ''
    if (form.historyContent === '') {
        usePage().props.error = 'History content cannot be empty!'
        return false;
    }
    return true;
}

const openEmailModal = () => {
    useStore().setIsLoading(true)
    askContactEmailContent(userWebsite?.value?.website?.name).then((response) => {
        isEmailModalOpen.value = true
        emailTemplate.value = response
        useStore().setIsLoading(false)
    })
}


const copy = () => {
    Clipboard.writeClipboard(emailTemplate.value)
    useStore().setToast('Copied to clipboard.')
}

</script>

<template>
    <Head v-bind:title="$t('Website')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('Website')"/>
        </template>
        <Box>
            <div class="text-center text-2xl font-bold mb-4 uppercase">{{ userWebsite?.website.name }}</div>
            <div class="text-center">Url :
                <a :href="'https://www.' + userWebsite?.website.url" target="_blank">{{ userWebsite?.website.url }}</a>
            </div>
        </Box>
        <Box>
            <div v-if="userWebsite?.website.techs.length>0" class="underline mb-2">Used technologies</div>
            <div class="flex flex-row space-x-2">
                <div v-for="tech in userWebsite?.website.techs">{{ tech.tech.name }}</div>
            </div>
        </Box>
        <Box>
            <div v-if="userWebsite?.website.emails.length>0" class="underline mb-2">Emails</div>
            <div class="flex flex-col w-full space-y-1">
                <div v-for="email in userWebsite?.website.emails" class="flex flex-row justify-between">
                    <div class="">{{ email.email }}</div>
                </div>
            </div>
            <div class="flex justify-center">
                <SecondaryButton @click="openEmailModal()">Get contact email content suggestion</SecondaryButton>
            </div>
            <DialogModal :show="isEmailModalOpen" @close="isEmailModalOpen = false">
                <template #content>
                    <div>
                        <TextArea v-model="emailTemplate" class="w-full" rows="10"></TextArea>
                    </div>
                </template>
                <template #footer>
                    <div class="flex space-x-2">
                        <SecondaryButton v-if="emailTemplate" @click="copy" :title="'Copy to clipboard'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-clipboard-copy">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                                <path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                                <path d="M16 4h2a2 2 0 0 1 2 2v4"/>
                                <path d="M21 14H11"/>
                                <path d="m15 10-4 4 4 4"/>
                            </svg>
                        </SecondaryButton>
                        <SecondaryButton @click="isEmailModalOpen = false">
                            Close
                        </SecondaryButton>
                    </div>
                </template>
            </DialogModal>
        </Box>
        <Box>
            <div v-if="userWebsite?.histories.length>0" class="underline mb-2">History</div>
            <div v-else>No history</div>
            <div v-for="history in userWebsite?.histories" class="mb-2 bg-gradient-to-b from-neutral p-1">
                <div class="">
                    {{ history?.content }}
                </div>
                <div class="flex md:flex-row flex-col md:space-x-8 justify-end">
                    <div class="flex md:space-x-4 space-x-2 justify-end">
                        <div class="text-xs">Edit</div>
                        <div class="text-xs">Delete</div>
                    </div>
                    <div class="text-xs justify-end flex">Created at : {{ history?.created_at }}</div>
                </div>
            </div>
        </Box>
        <Box>
            <div>Add new history</div>
            <form @submit.prevent="submit" class="">
                <div class="mb-1">
                    <TextArea v-model="form.historyContent" class="w-full" :rows="'2'"/>
                </div>
                <ErrorAlert v-if="usePage().props.error" :error="usePage().props.error" class="my-2"
                            :hide-after-delay="true"/>
                <div class="flex justify-end">
                    <PrimaryButton type="submit" class="">Add</PrimaryButton>
                </div>
                <div v-if="form.errors?.email">{{ form.errors?.email }}</div>
            </form>
        </Box>
    </AppLayout>
</template>

