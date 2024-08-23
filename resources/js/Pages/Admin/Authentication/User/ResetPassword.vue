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
  user: {
    type: Object,
  },
});

const form = useForm({
  name: props.user.name,
  username: props.user.username,
  email: props.user.email,
  password: '',
  password_confirmation: '',
});

const updatePassword = () => {
  form.put(route('admin-user.update-password', { id: props.user.id }));
};
</script>

<template>

  <Head title="Admin Users | Reset Password" />

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
            <Link :href="route('admin-user.index')"
              class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600">
            Users
            </Link>
            <AngleRightIcon class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400" />
          </li>
          <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
            Reset Password
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
                <h2 class="text-lg font-medium text-gray-900">Reset Password</h2>
              </header>

              <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
                <div>
                  <InputLabel for="username" value="Username" />

                  <TextInput id="username" type="text" class="mt-1 block w-full text-gray-500 cursor-not-allowed"
                    v-model="form.username" autocomplete="off" disabled />
                </div>

                <div>
                  <InputLabel for="name" value="Name" />

                  <TextInput id="name" type="text" class="mt-1 block w-full text-gray-500 cursor-not-allowed"
                    v-model="form.name" autocomplete="off" disabled />
                </div>

                <div>
                  <InputLabel for="email" value="Email" />

                  <TextInput id="email" type="email" class="mt-1 block w-full text-gray-500 cursor-not-allowed"
                    v-model="form.email" autocomplete="off" disabled />

                  <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                  <InputLabel for="password" value="Password" />

                  <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                    autocomplete="new-password" autofocus />

                  <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                  <InputLabel for="password_confirmation" value="Confirm Password" />

                  <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" autocomplete="new-password" />

                  <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end">
                  <SecondaryButtonLink :href="route('admin-user.index')">Cancel</SecondaryButtonLink>
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
