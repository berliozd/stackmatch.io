<script setup>
import {usePage} from "@inertiajs/vue3";
</script>
<template>

    <section class="text-center md:p-12 p-6 md:py-16 space-y-12 md:space-y-16 bg-neutral">

        <h2 class="max-w-2xl md:mx-auto font-extrabold mb-6 md:mb-8 md:text-5xl text-2xl">
            Find websites that speak your
            <span class="bg-base-300 px-2 md:px-4 ml-1 md:ml-1.5 leading-relaxed">technology</span>
            language.
        </h2>

        <p class="max-w-2xl mx-auto text-lg leading-relaxed">
            With {{ usePage().props.app.name }}, you can easily find websites that use your favorite technologies and
            are located in different countries.
            <br>
            <br>
            Join us today and unlock the secrets of the web's most successful sites.
        </p>

        <h2 class="max-w-2xl md:mx-auto font-extrabold mb-6 md:mb-8 md:text-5xl text-2xl text-neutral-content">Use cases</h2>

        <div class="max-w-5xl bg-base-300 mx-auto rounded-box grid md:grid-cols-2 py-16 gap-8 md:gap-16">
            <div class="px-8">
                <span class="text-4xl">👨‍💻</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Developers</h3>
                <div class="">
                    Use our tool to prospect potential clients and showcase your expertise in their tech stack.
                </div>
            </div>
            <div class="px-8">
                <span class="text-4xl">👬</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Marketers</h3>
                <div class="">
                    Understand your competitors' marketing strategies by analyzing the technologies they use.
                </div>
            </div>
            <div class="px-8">
                <span class="text-4xl">👨🏾</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Creator of technical solutions</h3>
                <div class="">
                    Promote your technical solutions to companies that use the technologies you master.
                </div>
            </div>
            <div class="px-8">
                <span class="text-4xl">👩🏼‍🎓</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Recruiters</h3>
                <div class="">
                    Identify companies using specific technologies to match them with potential candidates with relevant
                    skills.
                </div>
            </div>
            <div class="px-8">
                <span class="text-4xl">👷🏿</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Entrepreneurs or start-ups</h3>
                <div class="">
                    Identify companies using complementary technologies for potential collaborations.
                </div>
            </div>
            <div class="px-8">
                <span class="text-4xl">💰</span>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Investors</h3>
                <div class="">
                    Identify potential investment opportunities by analyzing the technologies used by start-ups and
                    growth-stage companies.
                </div>
            </div>
        </div>

    </section>
</template>
