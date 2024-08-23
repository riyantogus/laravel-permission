<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButtonLink from '@/Components/SecondaryButtonLink.vue';
import TextInput from '@/Components/TextInput.vue';
import AngleRightIcon from '@/Components/Icons/AngleRightIcon.vue';

const props = defineProps({
  role: {
    type: Object,
  },
  permissions: {
    type: Object,
  },
  rolePermissions: {
    type: Object,
  },
});

const form = useForm({
  name: props.role.name,
  permissions: props.rolePermissions,
});

const update = () => {
  form.put(route('admin-role.update', { id: props.role.id }));
};
</script>

<template>

  <Head title="Admin Roles | Edit" />

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
            <Link :href="route('admin-role.index')"
              class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600">
            Roles
            </Link>
            <AngleRightIcon class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400" />
          </li>
          <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
            Edit
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
                <h2 class="text-lg font-medium text-gray-900">Edit Role</h2>
              </header>

              <form @submit.prevent="update" class="mt-6 space-y-6">
                <div>
                  <InputLabel for="name" value="Name" />

                  <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                    autocomplete="name" />

                  <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                  <span class="block font-medium text-sm text-gray-700">Permissions</span>

                  <div v-if="Object.keys(permissions).length > 0" class="grid grid-cols-1 md:grid-cols-3 mt-2">
                    <div class="flex items-center mb-4" v-for="(item, index) in permissions" :key="index">
                      <input type="checkbox"
                        class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2"
                        :id="'permission-' + index" v-model="form.permissions" :value="item.name">
                      <label class="ms-2 text-sm font-medium text-gray-600" :for="'permission-' + index">{{ item.name
                        }}</label>
                    </div>
                  </div>

                  <div v-else>
                    <span class="text-sm text-gray-600 ms-2 mt-2">Not found</span>
                  </div>
                </div>

                <div class="flex items-center justify-end">
                  <SecondaryButtonLink :href="route('admin-role.index')">Cancel</SecondaryButtonLink>
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
