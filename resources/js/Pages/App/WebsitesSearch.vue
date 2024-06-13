<script setup>
// https://pro.builtwith.com/generic.asmx?T=TECH&INIT=true
// https://api.builtwith.com/lists11/api.json?KEY=e83dd1f3-0502-4320-b18d-96e761dcb88c&TECH=Shopify&COUNTRY=US&meta=yes&SINCE=90%20Days%20Ago
// https://api.builtwith.com/lists11/api.json?KEY=e83dd1f3-0502-4320-b18d-96e761dcb88c&TECH=Magento%202&meta=yes&country=it&SINCE=90%20Days%20Ago
import PageHeader from "@/Components/PageHeader.vue";
import Box from "@/Components/Box.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Badges from "@/Components/Badges.vue";
import TextInput from "@/Components/TextInput.vue";
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {useStore} from "@/Composables/store.js";
import {_, debounce} from "lodash";
import Collapsable from "@/Components/Collapsable.vue";

const tech = ref(null)
const techSearch = ref(null)
const country = ref(null)
const websites = ref(null)
const techOpen = ref(false)
const countryOpen = ref(false)
const techs = ref(null)
const countries = [
    {'id': 0, 'label': 'US'},
    {'id': 1, 'label': 'FR'},
    {'id': 2, 'label': 'IT'},
]

const getWebsites = async () => {
    try {
        if (tech.value == null || country.value === null) {
            return
        }
        techOpen.value = countryOpen.value = false
        useStore().setIsLoading(true)
        const url = '/api/websites/search'
        const response = await axios.get(url, {
            params: {'tech': tech.value?.label, 'country': country.value?.label}
        })
        useStore().setIsLoading(false)
        prepare(response)
        websites.value = response.data
    } catch (error) {
        useStore().setIsLoading(false)
        console.log(error)
    }
}

const prepare = function (response) {
    response.data.map((tech) => {
        tech.label = _.truncate(tech.name ?? tech.D)
    })
    response.data.sort((a, b) => {
        if (a.label > b.label) {
            return 1
        }
        return (a.label < b.label) ? -1 : 0
    })
}

const getTechs = debounce(async () => {
    try {
        if (techSearch.value === '') {
            techs.value = null;
            return;
        }
        useStore().setIsLoading(true)
        const url = '/api/techs/search/' + techSearch.value
        const response = await axios.get(url)
        useStore().setIsLoading(false)
        prepare(response);
        techs.value = response.data
    } catch (error) {
        useStore().setIsLoading(false)
        console.log(error)
    }
}, 1000)


const setCountry = (event) => {
    websites.value = null
    country.value = event
}

const setTech = (event) => {
    websites.value = null
    tech.value = event
}

const addWebsite = async (website) => {
    console.log(website);
    // console.log(JSON.parse(JSON.stringify(website.META?.Social)));
    const websiteData = {
        url: website.D,
        name: website.META?.CompanyName,
        city: website.META?.City,
        postcode: website.META?.Postcode,
        country: website.META?.Country,
        emails: JSON.parse(JSON.stringify(website.META?.Emails)),
        phones: JSON.parse(JSON.stringify(website.META?.Telephones)),
        socials: JSON.parse(JSON.stringify(website.META?.Social)),
        techs: [JSON.parse(JSON.stringify(tech.value))]
    }
    await axios.post('/api/websites/add', websiteData)
        .then(response => {
            useStore().setToast('Added!')
        })
        .catch(error => {
            console.error(error);
        });
    console.log(websiteData);
}
</script>

<template>
    <Head v-bind:title="$t('My stacks')"/>
    <AppLayout>
        <template #header>
            <PageHeader v-bind:title="$t('Websites search')"/>
        </template>

        <Collapsable :open="true" title="Websites search">
            Welcome to our technology stack search tool! With this tool, you can easily find websites that use specific
            technologies in a particular country. Simply select the technology and country you're interested in, and
            click the search button to see a list of websites that match your criteria.
            <br/>
            <br/>
            Our tool is powered by a comprehensive database of website technology stacks, which is updated regularly to
            ensure that the information is accurate and up-to-date. Whether you're a developer looking for inspiration,
            a researcher studying the adoption of certain technologies, or just curious about the technologies used by
            websites in a particular country, our tool has you covered.
        </Collapsable>

        <Box class="min-h-52">
            <div
                class="bg-neutral-content/40 shadow-lg shadow-secondary-content/40 border rounded-lg p-4 flex flex-col mb-4">
                <label for="tech">Search and select one tech : </label>
                <TextInput v-model="techSearch" @input="getTechs" class="text-black mb-5"
                           :placeholder="'Start typing here...'"></TextInput>
                <Badges :badges="techs" :badge="tech?.id" @click="setTech($event);"/>
            </div>
            <div
                class="bg-neutral-content/40 shadow-lg shadow-secondary-content/40 border rounded-lg p-4 flex flex-col">
                <label for="country">Select a country : </label>
                <Badges :badges="countries" :badge="country?.id" @click="setCountry($event);"/>
            </div>
            <div class="flex flex-row space-x-2 justify-between mt-2">
                <div class="text-primary">
                    <template v-if="tech && country">
                        <div>You have selected <span class="font-bold underline">{{ tech.label }}</span> and <span
                            class="font-bold underline">{{ country.label }}</span>.
                        </div>
                        <div>You can search for websites.</div>
                    </template>
                </div>
                <PrimaryButton @click="getWebsites">Get websites</PrimaryButton>
            </div>
            <div v-if="websites">
                <hr class="my-4">
                <div class="items-center justify-between mt-2">
                    <div v-for="website in websites"
                         class="inline-flex rounded-lg shadow-lg shadow-secondary-content/40 mr-1 mb-1 p-1 space-x-2 border">
                        <span @click="addWebsite(website)" class="hover:cursor-pointer">{{ website.D }}</span>
                    </div>
                </div>
            </div>
        </Box>

    </AppLayout>
</template>

