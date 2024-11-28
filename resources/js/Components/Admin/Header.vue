<script setup>
import { usePage } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';

const user = usePage().props.auth.user;
</script>

<template>
  <header
    class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 sm:py-4 lg:ps-64">
    <nav class="flex basis-full items-center w-full mx-auto px-4 sm:px-6" aria-label="Global">
      <button type="button"
        class="lg:hidden py-2 px-3 flex justify-center items-center gap-x-1.5 text-xs rounded-lg border border-gray-200 text-gray-500 hover:text-gray-600"
        data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Sidebar">
        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 8L21 12L17 16M3 12H13M3 6H13M3 18H13" />
        </svg>
        <span class="sr-only">Sidebar</span>
      </button>

      <div class="w-full flex items-center justify-end ms-auto">

        <div class="flex flex-row items-center justify-end gap-2">
          <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
            <button id="hs-dropdown-with-header" type="button"
              class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
              <img class="inline-block rounded-full w-9 h-auto ring-2 ring-white" :src="'/johnwick.png'" alt="Avatar">
            </button>

            <div
              class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2"
              aria-labelledby="hs-dropdown-with-header">
              <div class="py-3 px-5 -m-2 bg-gray-100 rounded-t-lg">
                <p class="text-sm text-gray-500">Signed in as</p>
                <p class="text-sm font-medium text-gray-800">{{ user.email }}</p>
              </div>
              <div class="mt-2 py-2 first:pt-0 last:pb-0">
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-500"
                  :href="route('admin-home.index')">
                  Dashboard
                </a>
                <DropdownLink
                  class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-500"
                  :href="route('logout')" method="post" as="button">
                  Log Out
                </DropdownLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>