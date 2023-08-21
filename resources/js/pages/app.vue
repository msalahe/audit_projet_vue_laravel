<script setup>
import { reactive } from 'vue';
import Header from '../components/layouts/header.vue';
import footer from '@/components/layouts/footer.vue';
import issues from '@/components/modals/issues/index.vue'
import { useIssueStore } from '@/stores/issue'
const issueStore = useIssueStore()

</script>


<template>
    <Header></Header>

     <router-view></router-view>
   


</template>



<style>

</style>
