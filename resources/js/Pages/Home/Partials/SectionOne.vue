<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ListTick from "@/Components/ListTick.vue";
import Arrow from "@/Components/Arrow.vue";

import {router} from "@inertiajs/vue3";
</script>

<template>
    <section class="md:p-12 p-6 mx-auto">
        <div class="px-8 pb-6 flex flex-col gap-10 lg:gap-14 items-center text-center">
            <h1 class="md:text-7xl text-3xl my-6 font-extrabold leading-normal">
                Find websites <br> that use your <span class="border-b-8 border-dashed border-primary/50 italic">technology</span>.
            </h1>
            <div class="text-lg max-w-xl mx-auto">

                Whether you are a developer, creator of technical solutions, recruiter or investor, our platform allows
                you to discover websites that use technologies that you master or that interest you.
                <br><br>
                Explore thousands
                of sites based on the technologies they use, whether frameworks, programming languages, databases, or
                other technology tools.

<!--                Ever wondered what technologies your favorite websites are built with?-->
<!--                <br>-->
<!--                <br>-->
<!--                Our powerful SaaS solution lets you uncover the tech stack behind any website with just a click. Whether-->
<!--                you're a developer looking to stay ahead of the curve, a marketer seeking insights, or a business owner-->
<!--                evaluating competitors, we've got you covered.-->
<!--                <br>-->
<!--                <br>-->
<!--                With our advanced search and filtering options, you can explore websites by specific technologies.-->
<!--                <br>-->
<!--                <br>-->
<!--                Join us today and unlock the secrets of the web's most successful sites.-->
            </div>
            <ul class="space-y-1.5">
                <li class="flex items-center justify-start gap-2">
                    <ListTick>Start for free</ListTick>
                </li>
                <li class="flex items-center justify-start gap-2">
                    <ListTick>Search for websites</ListTick>
                </li>
                <li class="flex items-center justify-start gap-2">
                    <ListTick>Get insights</ListTick>
                </li>
            </ul>
            <PrimaryButton @click="router.visit('register')">
                <Arrow>Get started</Arrow>
            </PrimaryButton>
        </div>
    </section>
</template>
