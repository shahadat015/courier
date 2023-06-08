<template>
    <ul class="border-b-2 pb-2 border-gray-300 dark:border-gray-600">
        <li v-for="(tab, index) in tabs" :key="tab" class="inline-block">
            <a class="text-sm font-semibold px-6 py-[.7rem] cursor-pointer text-gray-700 dark:text-gray-300 transition" @click="toggleTabs(index)" :class="{'border-b-2 border-purple-600': activeTab == index}">
                {{ tab.replace('-', ' ') }}
            </a>
        </li>
    </ul>
    <div class="mt-6">
        <div v-for="(tab, index) in tabs" :key="tab" :class="activeTab == index ? 'block': 'hidden'">
            <slot :name="tab"></slot>
        </div>
    </div>
</template>
<script>
export default {
    props: ['tabs'],
    data(){
        return {
            activeTab: 0,
        }
    },
    methods: {
        toggleTabs(tab){
            this.activeTab = tab
        }
    }
}
</script>