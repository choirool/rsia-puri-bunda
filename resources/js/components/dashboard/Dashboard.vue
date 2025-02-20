<template>
    <div class="flex justify-between w-full gap-2 mb-2">
        <TotalUser />
        <TotalLogin />
    </div>
    <div class="flex justify-between w-full gap-2 mb-2">
        <TotalUnit />
        <TotalPosition />
    </div>
    <div class="flex justify-between w-full gap-2">
        <TopTenUserLogin />
    </div>
</template>

<script setup>
import { defineAsyncComponent } from "vue";

const TotalUser = defineAsyncComponent(() => import("./TotalUser.vue"));
const TotalUnit = defineAsyncComponent(() => import("./TotalUnit.vue"));
const TotalPosition = defineAsyncComponent(() => import("./TotalPosition.vue"));
const TotalLogin = defineAsyncComponent(() => import("./TotalLogin.vue"));
const TopTenUserLogin = defineAsyncComponent(() =>
    import("./TopTenUserLogin.vue")
);
</script>
