<template>
    <div class="col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-md p-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 text-center md:text-right">
            <div class="p-4 bg-green-500 rounded-md shadow-sm space-y-3 text-white">
                <h3>Performance</h3>
                <p>{{ data.performance }}</p>
            </div>
            <div class="p-4 bg-blue-500 rounded-md shadow-sm space-y-3 text-white">
                <h3>Total Parcel Delivered</h3>
                <p> {{ data.parcel_delivered }}</p>
            </div>
            <div class="p-4 bg-purple-500 rounded-md shadow-sm space-y-3 text-white">
                <h3>Delivery Rate</h3>
                <p>{{ data.delivery_rate }}%</p>
            </div>
            <div class="p-4 bg-red-500 rounded-md shadow-sm space-y-3 text-white">
                <h3>Cancel Rate</h3>
                <p>{{ data.cancel_rate }}%</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data']
    }
</script>