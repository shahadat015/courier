<template>
    <input
        class="block w-full mt-1 text-sm text-black dark:text-gray-300 border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
        :type="inputType"
        :placeholder="placeholder"
        :class="classes"
        :value="value"
        @input="$emit('inputEvent', $event.target.value)"
        :disabled="disabled"
    />
</template>
<script>
    export default {
        props: {
            inputType: {
                type: String,
                default: 'text'
            }, 
            placeholder: {
                type: String,
                default: 'Please Enter'
            },
            classes: {
                type: String
            },
            value: {
                type: [String, Number]
            },
            disabled: {
                type: Boolean
            }
        },
    }
</script>