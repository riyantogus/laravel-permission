<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Modal from '@/Components/Modal.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DotsHorizontalIcon from '@/Components/Icons/DotsHorizontalIcon.vue';

const props = defineProps({
  id: {
    type: Number,
  }
});

const form = useForm({
  id: props.id,
});

const confirmingDeletion = ref(false);

// delete modal
const confirmDeletion = () => {
  confirmingDeletion.value = true;
};

const closeModal = () => {
  confirmingDeletion.value = false;

  form.reset();
};

const deleteRole = () => {
  form.delete(route('admin-role.destroy', { id: form.id }), {
    replace: false,
    preserveState: false,
    preserveScroll: false,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <div class="inline-flex items-center bg-white rounded-lg transition-all">
    <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
      <button id="hs-table-dropdown-3" type="button"
        class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 align-middle focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-600 transition-all text-sm"
        aria-label="actions">
        <DotsHorizontalIcon class="w-4 h-4" />
      </button>
      <div
        class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-10 bg-white shadow-2xl rounded-lg p-2 mt-2"
        aria-labelledby="hs-table-dropdown-3">
        <div class="py-2 first:pt-0 last:pb-0">
          <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400">
            Actions
          </span>
          <Link
            class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-500"
            :href="route('admin-role.edit', { id: props.id })">
          Edit
          </Link>
          <button
            class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-500"
            @click="confirmDeletion">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>

  <Modal :show="confirmingDeletion" @close="closeModal">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
        Are you absolutely sure?
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        This action cannot be undone and data will be permanently deleted.
      </p>

      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

        <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
          @click="deleteRole">
          Delete
        </DangerButton>
      </div>
    </div>
  </Modal>
</template>