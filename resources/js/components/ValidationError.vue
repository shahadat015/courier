<template>
    <span class="text-xs text-red-600 dark:text-red-400" v-if="errors && errors[field]">
        {{ errors[field][0] }}
    </span>
</template>
<script>
    export default {
        props: {
            errors: {
                required: true,
            },
             field: {
                 type: String,
                 required: true
             }
        }
    }
</script>