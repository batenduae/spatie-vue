<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/TailAdmin/Breadcrumbs/BreadcrumbDefault.vue'
import CalendarCard from '@/Components/TailAdmin/CalendarCard.vue'
import TailAdminLayout from "@/Layouts/TailAdminLayout.vue";

const pageTitle = ref('Calender')
</script>

<template>
  <TailAdminLayout>
    <div class="mx-auto max-w-7xl">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <CalendarCard />
    </div>
  </TailAdminLayout>
</template>
