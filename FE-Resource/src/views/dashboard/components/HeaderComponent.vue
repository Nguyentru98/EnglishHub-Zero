<template>
    <div>
        <div>
           <nav class="border p-3">
                <RouterLink to="/">Home</RouterLink>
                <RouterLink class="p-2" to="/reactivity">Reactivity</RouterLink>
                <RouterLink class="p-2" to="/list">list product</RouterLink>
            </nav>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { RouterLink } from 'vue-router';
</script>