<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Arrow from "@/Components/Arrow.vue";

import {router, usePage} from "@inertiajs/vue3";
</script>
<template>
    <section class=" text-center md:p-12 p-6 bg-neutral">
        <div class="max-w-3xl bg-base-100 mx-auto rounded-box">
            <div class="flex flex-col items-center p-12 md:p-16">
                <h2 class="text-3xl md:text-5xl mb-8 md:mb-12">Start building your network</h2>
                <p class="text-lg text-base-content-secondary mb-12 md:mb-16">
                    Target and connect with companies that use technologies you understand.
                    Our tool thus facilitates the identification of potential customers and future business partners.
                </p>
                <PrimaryButton @click="router.visit('register')">
                    <Arrow>Try {{ usePage().props.app.name }}</Arrow>
                </PrimaryButton>
            </div>
        </div>
    </section>
</template>
