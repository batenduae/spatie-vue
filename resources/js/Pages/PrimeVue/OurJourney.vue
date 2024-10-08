<script setup>
import {ref} from "vue";

const events = ref([
    {
        status: '43rd BCS Circular',
        date: '15/10/2020 10:30',
        icon: 'pi pi-book',
        color: '#9C27B0',
        image: 'game-controller.jpg',
        text: 'I am Md. Abdul Baten'
    },
    {
        status: 'Preliminary Exam',
        date: '15/10/2020 14:00',
        icon: 'pi pi-check-circle',
        color: '#673AB7',
        image: 'game-controller.jpg',
        text: 'I am Md. Abdul Baten'
    },
    {
        status: 'Written Exam',
        date: '15/10/2020 - 25/10/2020',
        icon: 'pi pi-pencil',
        color: '#FF9800',
        image: 'game-controller.jpg',
        text: 'I am Md. Abdul Baten'
    },
    {
        status: 'Viva Voce',
        date: '16/10/2020 10:00',
        icon: 'pi pi-filter',
        color: '#607D8B',
        image: 'game-controller.jpg',
        text: 'I am Md. Abdul Baten'
    },
    {
        status: 'Result Published',
        date: '16/10/2020 10:00',
        icon: 'pi pi-send',
        color: '#607D8B',
        image: 'game-controller.jpg',
        text: 'I am Md. Abdul Baten'
    },
]);

</script>

<template>
    <div class="card mb-8 bg-gradient-to-b from-purple-100 to-indigo-200 py-4">
        <Timeline :value="events" align="alternate" class="customized-timeline">
            <template #marker="slotProps">
                <span :style="{ backgroundColor: slotProps.item.color }"
                      class="flex w-8 h-8 items-center justify-center text-white rounded-full z-10 shadow-sm">
                    <i :class="slotProps.item.icon"></i>
                </span>
            </template>
            <template #opposite="slotProps">
                <small class="text-surface-500 dark:text-surface-400">{{ slotProps.item.status }}</small>
            </template>
            <template #content="slotProps">
                <Card class="mt-4">
                    <template #title>
                        {{ slotProps.item.status }}
                    </template>
                    <template #subtitle>
                        {{ slotProps.item.date }}
                    </template>
                    <template #content>
                        <img v-if="slotProps.item.image"
                             :alt="slotProps.item.name"
                             :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.item.image}`" class="shadow-sm" width="200"/>
                        <p v-if="slotProps.item.text">
                            {{ slotProps.item.text }}
                        </p>
                        <Button label="Read more" text></Button>
                    </template>
                </Card>
            </template>
        </Timeline>
    </div>
</template>


<style lang="scss" scoped>
@media screen and (max-width: 960px) {
    ::v-deep(.customized-timeline) {
        .p-timeline-event:nth-child(even) {
            flex-direction: row;

            .p-timeline-event-content {
                text-align: left;
            }
        }

        .p-timeline-event-opposite {
            flex: 0;
        }
    }
}
</style>
