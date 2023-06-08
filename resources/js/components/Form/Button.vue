<template>
    <button 
        class="px-4 py-2 text-sm font-medium leading-5 disabled:opacity-50 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        :class="classes"
        :disabled="disabled"
    >
        <slot>Submit</slot> 
    </button>
</template>
<script>
    export default {
        props: ['classes', 'disabled']
    }
</script>