<template>
    <select 
        class="py-2 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
        :class="classes"
        :value="value"
        @change="$emit('changeEvent', $event.target.value)"
    >
        <slot></slot>   
    </select>
</template>
<script>
    export default {
        props: ['classes', 'value'],
    }
</script>