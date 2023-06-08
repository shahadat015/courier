<template>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-md px-2 py-8 text-center">
        <img :src="user.image ?? '/images/male-avater.png'" class="w-16 mx-auto h-16 rounded-full" alt="">
        <h2 class=" font-normal text-gray-700 text-lg mt-2 dark:text-gray-200">{{ user.name }}</h2>
        <p class="font-normal text-gray-600 text-md dark:text-gray-200">ID #{{ user.id }}</p>
        <span class="font-normal text-green-600 text-xs inline-block my-2  px-2 rounded-full bg-green-200 dark:bg-green-500 dark:text-white">{{ user.status }}</span>
        <p class="font-normal text-gray-600 text-sm dark:text-gray-200 mb-1">{{ user.phone }}</p>
        <p class="font-normal text-gray-600 text-sm dark:text-gray-200">{{ user.email }}</p>
    </div>
</template>
<script>
    export default {
        props: ['user']
    }
</script>