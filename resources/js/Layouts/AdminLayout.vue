<script setup lang="ts">
import { nextTick, onMounted } from 'vue';
import Header from '@/Components/Admin/Header.vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';
import FlashMessages from '@/Components/FlashMessages.vue';

import { type IStaticMethods } from "preline/preline";

declare global {
  interface Window {
    HSStaticMethods?: IStaticMethods;
  }
}

onMounted(async () => {
  await nextTick();
  if (window.HSStaticMethods) {
    window.HSStaticMethods.autoInit();
  }
});
</script>

<template>
  <!-- ========== HEADER ========== -->
  <Header />
  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <!-- Sidebar -->
  <Sidebar />
  <!-- End Sidebar -->

  <!-- Content -->
  <main>
    <div class="w-full lg:ps-64">
      <div class="flex flex-col px-6 py-4 gap-2">
        <slot name="breadcrumb" />

        <FlashMessages />

        <slot />
      </div>
    </div>
  </main>
  <!-- End Content -->
  <!-- ========== END MAIN CONTENT ========== -->
</template>