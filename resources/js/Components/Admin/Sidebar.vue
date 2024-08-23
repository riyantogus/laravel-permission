<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import HomeIcon from '@/Components/Icons/HomeIcon.vue';
import UserSettingIcon from '@/Components/Icons/UserSettingIcon.vue';
import ApplicationLogo from '../ApplicationLogo.vue';

const roles = usePage().props.auth.can.roles;
</script>

<template>
  <aside id="application-sidebar" class="hs-overlay [--auto-close:lg] [--overlay-backdrop:false]
  hs-overlay-open:translate-x-0
  -translate-x-full transition-all duration-300 transform
  w-[260px]
  hidden
  fixed inset-y-0 start-0 z-[60]
  bg-neutral-800 border-e border-neutral-700
  lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
 ">
    <div class="flex items-center justify-between lg:justify-center px-6 lg:px-0 pt-4">
      <!-- Logo -->
      <Link class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80" href="#"
        aria-label="Laravel Permission">
      <ApplicationLogo class="w-12 h-12 fill-current text-neutral-400 hover:text-neutral-300" />
      </Link>
      <!-- End Logo -->
      <button type="button"
        class="inline-flex lg:hidden justify-center items-center gap-x-2 text-neutral-400 hover:text-neutral-300 focus:text-neutral-300 focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        aria-label="Close" data-hs-overlay="#application-sidebar">
        <span class="sr-only">Close</span>
        <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </button>
    </div>

    <nav class="p-6 w-full flex flex-col flex-wrap">
      <ul class="hs-accordion-group space-y-1.5">
        <li>
          <Link
            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg hover:bg-neutral-700 text-neutral-400 hover:text-neutral-300"
            :href="route('admin-home.index')">
          <HomeIcon class="flex-shrink-0 size-4" />
          Dashboard
          </Link>
        </li>

        <li v-if="roles.includes('Super Admin')" class="hs-accordion" id="authentication-accordion">
          <button type="button"
            class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-white hs-accordion-active:hover:bg-transparent text-sm rounded-lg bg-neutral-800 hover:bg-neutral-700 text-neutral-400 hover:text-neutral-300">
            <UserSettingIcon class="flex-shrink-0 mt-0.5 size-5" />
            Authentication

            <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round">
              <path d="m18 15-6-6-6 6" />
            </svg>

            <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round">
              <path d="m6 9 6 6 6-6" />
            </svg>
          </button>

          <div id="authentication-accordion-child"
            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
            <ul class="pt-2 ps-3">
              <li>
                <Link
                  class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg bg-neutral-800 text-neutral-400 hover:text-neutral-300"
                  :href="route('admin-user.index')">
                Users
                </Link>
              </li>
              <li>
                <Link
                  class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg bg-neutral-800 text-neutral-400 hover:text-neutral-300"
                  :href="route('admin-role.index')">
                Roles
                </Link>
              </li>
              <li>
                <Link
                  class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg bg-neutral-800 text-neutral-400 hover:text-neutral-300"
                  :href="route('admin-permission.index')">
                Permissions
                </Link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
  </aside>
</template>