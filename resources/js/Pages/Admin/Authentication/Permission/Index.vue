<script setup>
import { nextTick, ref, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionForm from '@/Pages/Admin/Authentication/Permission/Partials/ActionForm.vue';
import AngleRightIcon from "@/Components/Icons/AngleRightIcon.vue";
import { throttle } from "lodash";

const props = defineProps({
  filters: {
    type: Object,
  },
  permissions: {
    type: Object,
  },
});

const search = ref(props.filters.search);

watch(
  () => search.value,
  throttle((value) => {
    router.get(route('admin-permission.index'), { search: value }, {
      replace: true,
      preserveState: true,
      preserveScroll: true,
      only: ['filters', 'permissions'],
      onSuccess: () => {
        nextTick(() => {
          // Trigger Preline re-initialization
          window.HSStaticMethods.autoInit();
        });
      },
      onError: (error) => {
        console.error("Error fetching permission data:", error);
      }
    });
  }, 500)
);
</script>

<template>

  <Head title="Admin Permissions" />

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
          <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
            Permissions
          </li>
        </ol>
      </nav>
    </template>

    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden">

            <!-- Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
              <!-- Input -->
              <div class="sm:col-span-1">
                <form>
                  <label for="search" class="sr-only">Search</label>
                  <div class="relative">
                    <input type="text" id="search" name="search"
                      class="py-2 px-3 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                      placeholder="Search" v-model="search">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                      <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                          d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                      </svg>
                    </div>
                  </div>
                </form>
              </div>
              <!-- End Input -->

              <div class="sm:col-span-2 md:grow">
                <div class="flex justify-end">
                  <PrimaryButtonLink :href="route('admin-permission.create')">Create</PrimaryButtonLink>
                </div>
              </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                        Name
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                        Created At
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-end"></th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200">
                <tr v-for="each in props.permissions.data" :key="each.id">
                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span class="text-sm text-gray-600">{{ each.name }}</span>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span class="text-sm text-gray-600">{{ each.created_at }}</span>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-1.5 flex justify-end">
                      <ActionForm :id="each.id" />
                    </div>
                  </td>
                </tr>

                <tr v-if="props.permissions.data.length === 0">
                  <td class="size-px whitespace-nowrap text-center" colspan="3">
                    <div class="px-6 py-3">
                      <span class="text-sm text-gray-600">No data available in table</span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End Table -->

            <!-- Footer -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
              <div>
                <span class="text-sm font-normal text-gray-700 block w-full md:inline md:w-auto">
                  Showing
                  <span v-if="props.permissions.total === 0">{{ props.permissions.total }}</span>
                  <span v-else-if="props.permissions.total === 1">{{ props.permissions.from }}</span>
                  <span v-else>{{ props.permissions.from + ' - ' + props.permissions.to }}</span>
                  of
                  <span class="font-semibold text-gray-900">{{ props.permissions.total }}</span>
                </span>
              </div>
              <div>
                <Pagination :links="props.permissions.links" />
              </div>
            </div>
            <!-- End Footer -->
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>