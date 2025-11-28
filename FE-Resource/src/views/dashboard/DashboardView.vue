<template>
  <div>
    <HeaderCp />
    <router-view/>
  </div>
</template>

<script setup lang="ts">
    import { RouterView } from 'vue-router';
    import HeaderCp from './components/HeaderComponent.vue';
</script>