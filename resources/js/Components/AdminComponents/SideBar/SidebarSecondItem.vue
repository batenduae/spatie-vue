<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar'
import {Link} from "@inertiajs/vue3";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";
import SidebarThirdItem from "@/Components/AdminComponents/SideBar/SidebarThirdItem.vue";
const { hasPermission, showFlash} = usePermissions();

const currentPage = route().current()
const sidebarStore = useSidebarStore()

const props = defineProps(['item', 'index'])
interface SidebarItem {
  label: string
}

const handleItemClick = () => {
  const pageName = sidebarStore.page2 === props.item.label ? '' : props.item.label
  sidebarStore.page2= pageName

  if (props.item.children) {
    return props.item.children.some((child: SidebarItem) => sidebarStore.selected === child.label)
  }
}

</script>

<template>
  <li v-if="item.permission?hasPermission(item.permission):true">
    <Link
      :href="item.routeType=='named'?route(item.route):item.route"
      :active="item.active?route().current(item.active):''"
      class="group relative flex items-center gap-2.5 py-2 px-4 rounded-lg font-medium ease-in-out hover:bg-gradient-to-tl hover:from-purple-600 hover:to-teal-500 hover:rounded-lg"
      @click.prevent="handleItemClick"
      :class="route().current(item.active)?'bg-gradient-to-br dark:bg-gradient-to-br from-emerald-500 to-indigo-900 ':''"
      :color="(item.label === sidebarStore.selected)?'red':'green'"
    >
      <span v-html="item.icon"></span>
      {{ item.label }}
      <svg
        v-if="item.children"
        class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
        :class="{ 'rotate-180': sidebarStore.page2 === item.label }"
        width="20"
        height="20"
        viewBox="0 0 20 20"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
          fill=""
        />
      </svg>
    </Link>

    <!-- Dropdown Menu Start -->
    <div class="translate transform overflow-hidden" v-show="sidebarStore.page2 === item.label">
        <div class="pl-4" v-if="item.children">
            <SidebarThirdItem
                v-for="(item, index) in item.children"
                :item="item"
                :key="index"
                :index="index"
            />
        </div>
      <!-- Dropdown Menu End -->
    </div>
  </li>
</template>
