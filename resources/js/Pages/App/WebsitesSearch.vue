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
import Collapsable from "@/Components/Collapsable.vue";

import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {useStore} from "@/Composables/store.js";
import {_, debounce} from "lodash";
import hasUsedFreeSearches from "@/Composables/App/hasUsedFreeSearches.js";
import hasMaxWebsites from "@/Composables/App/hasMaxWebsites.js";

const tech = ref(null)
const techSearch = ref(null)
const country = ref(null)
const websites = ref(null)
const techOpen = ref(false)
const countryOpen = ref(false)
const techs = ref(null)
const hasUsedFreeSearchesRef = ref(false)
const hasMaxWebsitesRef = ref(false)

const countries = [
    {label: 'AT', name: 'Austria', id: 1},
    {label: 'AF', name: 'Afghanistan', id: 2},
    {label: 'AU', name: 'Austria', id: 3},
    {label: 'BE', name: 'Belgium', id: 4},
    {label: 'BR', name: 'Brazil', id: 5},
    {label: 'CA', name: 'Canada', id: 6},
    {label: 'CH', name: 'Switzerland', id: 7},
    {label: 'CN', name: 'China', id: 8},
    {label: 'CZ', name: 'Czech Republic', id: 9},
    {label: 'DK', name: 'Denmark', id: 10},
    {label: 'ES', name: 'Spain', id: 11},
    {label: 'FI', name: 'Finland', id: 12},
    {label: 'GB', name: 'United Kingdom', id: 13},
    {label: 'GR', name: 'Greece', id: 14},
    {label: 'HK', name: 'Hong Kong', id: 15},
    {label: 'IN', name: 'India', id: 16},
    {label: 'JP', name: 'Japan', id: 17},
    {label: 'KR', name: 'Korea', id: 18},
    {label: 'MX', name: 'Mexico', id: 19},
    {label: 'MY', name: 'Malaysia', id: 20},
    {label: 'US', name: 'United States', id: 21},
    {label: 'FR', name: 'France', id: 22},
    {label: 'IT', name: 'Italy', id: 23},
    {label: 'UK', name: 'United Kingdom', id: 24},
    {label: 'DE', name: 'Germany', id: 25},
    {label: 'IN', name: 'India', id: 26},
    {label: 'NL', name: 'Netherlands', id: 27},
    {label: 'PH', name: 'Philippines', id: 28},
    {label: 'RU', name: 'Russia', id: 29},
    {label: 'TR', name: 'Turkey', id: 30},
    {label: 'TW', name: 'Taiwan', id: 31},
    {label: 'VN', name: 'Vietnam', id: 32},
    {label: 'ZA', name: 'South Africa', id: 33},
];

const getCountries = () => {
    countries.sort((a, b) => {
        if (a.label > b.label) {
            return 1
        }
        return (a.label < b.label) ? -1 : 0
    })
    return countries
}

const getWebsites = async () => {
    try {
        if (tech.value == null || country.value === null) {
            return
        }
        hasUsedFreeSearchesRef.value = false
        hasMaxWebsitesRef.value = false
        hasUsedFreeSearches().then((hasUsedFreeSearches) => {
            if (hasUsedFreeSearches) {
                hasUsedFreeSearchesRef.value = true
                console.log('Not access');
            } else {
                techOpen.value = countryOpen.value = false
                useStore().setIsLoading(true)
                axios.get('/api/websites/search', {
                    params: {'tech': tech.value?.label, 'country': country.value?.label}
                }).then((response) => {
                    useStore().setIsLoading(false)
                    prepare(response)
                    websites.value = response.data
                })
            }
        })

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

const reallyAddWebsite = async (website) => {
    const websiteData = {
        url: website.D,
        name: (website.META?.CompanyName && website.META?.CompanyName !== '') ? website.META?.CompanyName : website.D,
        city: website.META?.City ?? '',
        postcode: website.META?.Postcode ?? '',
        country: website.META?.Country ?? '',
        emails: JSON.parse(JSON.stringify(website.META?.Emails ?? [])),
        phones: JSON.parse(JSON.stringify(website.META?.Telephones ?? [])),
        socials: JSON.parse(JSON.stringify(website.META?.Social ?? [])),
        techs: [JSON.parse(JSON.stringify(tech.value))]
    }
    await axios.post('/api/websites/add', websiteData)
        .then(response => {
            useStore().setToast('Added!')
            let index = websites.value.indexOf(website);
            if (index !== -1) {
                websites.value.splice(index, 1);
            }
        })
        .catch(error => {
            console.error(error);
        });
}

const addWebsite = async (website) => {
    hasUsedFreeSearchesRef.value = false
    hasMaxWebsitesRef.value = false
    hasMaxWebsites().then((hasMaxWebsites) => {
        if (hasMaxWebsites) {
            hasMaxWebsitesRef.value = true
            console.log('Not access');
        } else {
            reallyAddWebsite(website);
        }
    })
}
const gotTo = (url) => {
    window.location.href = url
}
</script>

<template>
    <Head v-bind:title="$t('Websites search')"/>
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
                <Badges :badges="getCountries()" :badge="country?.id" @click="setCountry($event);"/>
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
            <div v-if="websites && websites.length>0">
                <hr class="my-4">
                <div class="items-center justify-between mt-2">
                    <div v-for="website in websites"
                         class="inline-flex rounded-lg shadow-lg shadow-secondary-content/40 mr-2 mb-1 p-1 space-x-2 border">
                        <span>{{ website.D }}</span>
                        <span class="tooltip" data-tip="Add">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-plus mx-auto hover:cursor-pointer tooltip" data-tip="Add"
                             @click="addWebsite(website)" alt="Add website">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                        </span>
                    </div>
                </div>
            </div>
        </Box>

        <Box v-if="hasUsedFreeSearchesRef || hasMaxWebsitesRef">
            <div class="flex flex-col space-y-2 p-4" ref="errorElement">
                <div class="flex flex-row justify-between alert alert-error">
                    <div>
                        <template v-if="hasMaxWebsitesRef">
                            {{
                                "You have reached the limit of free websites. " +
                                "Please consider subscribing to be able to add unlimited number of websites."
                            }}
                        </template>
                        <template v-else>
                            {{
                                "You have reached the limit of free searches. " +
                                "Please consider subscribing to get unlimited number of searches."
                            }}

                        </template>
                    </div>
                    <PrimaryButton @click="gotTo(route('subscribe.checkout'))">
                        {{ $t('app.subscribe') }}
                    </PrimaryButton>
                </div>
            </div>
        </Box>


    </AppLayout>
</template>
