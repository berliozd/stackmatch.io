<script setup>
import {useStore} from "@/Composables/store.js";
</script>
<template>
<span v-if="useStore().loading"
      class="loading loading-spinner bg-neutral-content mx-auto w-24
      border border-accent rounded-full animate-spin h-24 bottom-auto left-0 right-0 fixed"
      style="z-index: 10000">
</span>
</template>
