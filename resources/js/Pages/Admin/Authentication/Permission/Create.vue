<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButtonLink from '@/Components/SecondaryButtonLink.vue';
import TextInput from '@/Components/TextInput.vue';
import AngleRightIcon from '@/Components/Icons/AngleRightIcon.vue';

const form = useForm({
  name: '',
});

const submit = () => {
  form.post(route('admin-permission.store'));
};
</script>

<template>

  <Head title="Admin Permissions | Create" />

  <AdminLayout>
    <template #breadcrumb>
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center whitespace-nowrap">
          <li class="inline-flex items-center">
            <div class="flex items-center text-sm text-gray-500">
              Authentication
              <AngleRightIcon class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400" />
            </div>
          </li>
          <li class="inline-flex items-center">
            <Link :href="route('admin-permission.index')"
              class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600">
            Permissions
            </Link>
            <AngleRightIcon class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400" />
          </li>
          <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
            Create
          </li>
        </ol>
      </nav>
    </template>

    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden">

            <div class="px-6 py-4">
              <header>
                <h2 class="text-lg font-medium text-gray-900">Create Permission</h2>
              </header>

              <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                  <InputLabel for="name" value="Name" />

                  <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                    autocomplete="off" />

                  <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="flex items-center justify-end">
                  <SecondaryButtonLink :href="route('admin-permission.index')">Cancel</SecondaryButtonLink>
                  <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                  </PrimaryButton>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
