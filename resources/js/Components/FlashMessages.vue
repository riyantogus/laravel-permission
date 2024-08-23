<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const page = usePage();
const show = ref(true);

watch(
  () => page.props.flash,
  () => {
    // Handle the change
    show.value = true;
  },
  { deep: true }
);
</script>

<template>
  <div>
    <div v-if="page.props.flash.success && show" id="toast-success"
      class="bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-md p-4" role="alert">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
            <path d="m9 12 2 2 4-4"></path>
          </svg>
        </div>
        <div class="ms-2">
          <div class="text-sm font-medium">
            {{ page.props.flash.success }}
          </div>
        </div>
        <div class="ps-3 ms-auto">
          <div class="-mx-1.5 -my-1.5">
            <button type="button"
              class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-teal-50 focus:ring-teal-600"
              data-dismiss-target="#toast-success" aria-label="Close" @click="show = false">
              <span class="sr-only">Dismiss</span>
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="(page.props.flash.error || Object.keys(page.props.errors).length > 0) && show" id="toast-error"
      class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-md p-4" role="alert">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m15 9-6 6"></path>
            <path d="m9 9 6 6"></path>
          </svg>
        </div>
        <div class="ms-2">
          <div v-if="page.props.flash.error" class="text-sm font-medium">{{ page.props.flash.error }}
          </div>
          <div v-else class="text-sm font-medium">
            <span v-if="Object.keys(page.props.errors).length === 1">There is one form error.</span>
            <span v-else>There are {{ Object.keys(page.props.errors).length }} form errors.</span>
          </div>
        </div>
        <div class="ps-3 ms-auto">
          <div class="-mx-1.5 -my-1.5">
            <button type="button"
              class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600"
              data-dismiss-target="#toast-error" aria-label="Close" @click="show = false">
              <span class="sr-only">Dismiss</span>
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
