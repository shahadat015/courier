<template>
    <textarea 
        class="block w-full mt-1 text-sm dark:text-gray-300 border dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
        :class="classes" 
        :rows="rows" 
        :placeholder="placeholder"
        :value="value"
        @input="$emit('inputEvent', $event.target.value)"
    >
    </textarea>
</template>
<script>
    export default {
        props: {
            rows: {
                type: Number,
                default: 2
            }, 
            placeholder: {
                type: String,
                default: 'Please enter your message'
            },
            classes: {
                type: String
            },
            value: {
                type: String
            }
        },
    }
</script>