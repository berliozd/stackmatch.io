<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ListTick from "@/Components/ListTick.vue";
import Arrow from "@/Components/Arrow.vue";

import {router, usePage} from "@inertiajs/vue3";
</script>

<template>
  <section class="md:p-12 p-6 mx-auto">
    <div class="px-8 pb-6 flex flex-col gap-10 lg:gap-14 items-center text-center">
      <h1 class="md:text-7xl text-3xl my-6 font-extrabold leading-normal">
        Turn your
        <span class="border-b-8 border-dashed border-primary/50 italic">ideas</span>
        <br>
        into
        <span class="border-b-8 border-dashed border-primary/50 italic">successful projects</span>
      </h1>
      <div  class="text-lg max-w-xl mx-auto">
        Our AI-powered tool not only helps you track progress and collaborate, but also provides valuable insights and information on your project's potential, including competitor analysis.
        <br>
        Save time and make informed decisions with {{usePage().props.app.name}}.
      </div>
      <ul class="space-y-1.5">
        <li class="flex items-center justify-start gap-2">
          <ListTick>Start for free</ListTick>
        </li>
        <li class="flex items-center justify-start gap-2">
          <ListTick>Track your projects</ListTick>
        </li>
        <li class="flex items-center justify-start gap-2">
          <ListTick>Get help from AI</ListTick>
        </li>
      </ul>
      <PrimaryButton @click="router.visit('register')">
        <Arrow>Get started</Arrow>
      </PrimaryButton>
    </div>
  </section>
</template>
