<script setup></script>
<template>
    <section class=" text-center md:p-12 p-6">

        <div class="py-24 px-8 max-w-7xl mx-auto flex flex-col md:flex-row gap-12" id="faq">
            <div class="flex flex-col text-left basis-1/2">
                <p class="inline-block font-semibold text-accent mb-4">FAQ</p>
                <p class="sm:text-4xl text-3xl font-extrabold">Frequently Asked Questions</p>
            </div>
            <ul class="basis-1/2">
                <li>
                    <button
                        class="relative flex w-full py-5 font-semibold text-left border-t md:text-lg border-base-content/10"
                        aria-expanded="true">
                        <span class="flex-1  text-accent">How can I search for websites based on the technologies they use?</span>
                    </button>
                    <div class="opacity-80 overflow-hidden">
                        <div class="pb-5 leading-relaxed">
                            <div class="space-y-2 leading-relaxed">
                                Our platform has an advanced search engine that
                                allows you to filter websites based on the technologies they use. You can select
                                specific technologies (like React, PHP, etc.) or solution (Google Analytics, Akamai,
                                etc.) and
                                get a list of websites that use them.
                                This allows you to precisely target companies that match your skills and solutions.
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <button
                        class="relative flex w-full py-5 font-semibold text-left border-t md:text-lg border-base-content/10"
                        aria-expanded="true">
                        <span class="flex-1  text-accent">How can I promote my technical solutions to relevant companies?</span>
                    </button>
                    <div class="opacity-80 overflow-hidden">
                        <div class="pb-5 leading-relaxed">
                            <div class="space-y-2 leading-relaxed">
                                Using our tool, you can identify companies that use technologies compatible with your
                                solutions. Once you have found relevant prospects, you can contact them directly to
                                offer your services.
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </section>
</template>
