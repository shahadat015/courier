<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                All Riders
            </h2>

            <!-- New Table -->
            <app-table endpoint="riders" actionUrl="riders"></app-table>
        </div>
    </main>
</template>
<script>
    import AppTable from '../../components/Table.vue';

    export default {
        components: {
            AppTable,
        },
        
    }
</script>