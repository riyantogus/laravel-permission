<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: Array
})
</script>

<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap font-medium text-sm gap-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key"
          class="relative block rounded px-3 py-1.5 text-sm text-surface transition duration-300" v-html="link.label" />
        <Link v-else :key="`link-${key}`"
          class="relative block rounded px-3 py-1.5 text-sm text-surface transition duration-300 hover:bg-gray-100 focus:bg-gray-100 focus:text-gray-700 focus:outline-none"
          :class="{ 'bg-gray-100 text-gray-700': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>