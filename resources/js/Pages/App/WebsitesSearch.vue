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
import Separator from "@/Components/Separator.vue";

import {Head} from '@inertiajs/vue3';
import {inject, nextTick, ref} from "vue";
import {useStore} from "@/Composables/store.js";
import {_, debounce} from "lodash";
import hasUsedFreeSearches from "@/Composables/App/hasUsedFreeSearches.js";
import hasMaxWebsites from "@/Composables/App/hasMaxWebsites.js";
import incrementSearches from "@/Composables/App/incrementSearches.js";
import goTo from "@/Composables/App/goTo.js";
import getCountries from "@/Composables/App/getCountries.js";

const smoothScroll = inject('smoothScroll')
const tech = ref(null)
const techSearch = ref(null)
const country = ref(null)
const websites = ref(null)
const techOpen = ref(false)
const countryOpen = ref(false)
const techs = ref(null)
const hasUsedFreeSearchesRef = ref(false)
const hasMaxWebsitesRef = ref(false)
const showResults = ref(false)
const resultsElement = ref(null)
const errorElement = ref(null)

const getWebsites = async () => {
    showResults.value = false
    try {
        if (tech.value == null || country.value === null) {
            return
        }
        hasUsedFreeSearchesRef.value = false
        hasMaxWebsitesRef.value = false
        hasUsedFreeSearches().then((hasUsedFreeSearches) => {
            if (hasUsedFreeSearches) {
                hasUsedFreeSearchesRef.value = true
                scrollToErrorMessage()
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
                    showResults.value = true
                    scrollToResults()
                    incrementSearches()
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

const removeWebsite = (website) => {
    let index = websites.value.indexOf(website);
    if (index !== -1) {
        websites.value.splice(index, 1);
    }
}

function getWebsiteData(website) {
    return {
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
}

const reallyAddWebsite = async (website) => {
    await axios.post('/api/websites/add', getWebsiteData(website))
        .then(response => {
            useStore().setToast('Added!')
            removeWebsite(website);
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

const scrollToResults = () => {
    nextTick(() => {
        smoothScroll({
            scrollTo: resultsElement.value,
            hash: '#results'
        })
    })
}
const scrollToErrorMessage = () => {
    nextTick(() => {
        smoothScroll({
            scrollTo: errorElement.value,
            hash: '#error'
        })
    })
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
                <div class="text-accent">
                    <template v-if="tech && country">
                        <div>You have selected <span class="font-bold underline">{{ tech.label }}</span> and <span
                            class="font-bold underline">{{ country.name }}</span>.
                        </div>
                        <div>You can search for websites.</div>
                    </template>
                </div>
                <PrimaryButton @click="getWebsites">Get websites</PrimaryButton>
            </div>

            <div v-if="showResults" ref="resultsElement">
                <Separator :text="'Results'" class="mt-4"/>
                <div v-if="websites && websites.length>0">
                    <div class="items-center justify-between mt-2">
                        <div v-for="website in websites"
                             class="inline-flex rounded-lg shadow-lg shadow-secondary-content/40 mr-2 mb-1 p-1 space-x-2 border border-gray-300 dark:border-gray-500">
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
                <div v-else>
                    No results
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
                    <PrimaryButton @click="goTo(route('subscribe.checkout'))">
                        {{ $t('app.subscribe') }}
                    </PrimaryButton>
                </div>
            </div>
        </Box>


    </AppLayout>
</template>
