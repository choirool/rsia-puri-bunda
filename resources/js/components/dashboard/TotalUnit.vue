<template>
    <div class="w-full">
        <el-card>
            <template #header>
                <div class="card-header">
                    <span>Total Unit</span>
                </div>
            </template>
            <div class="text-center text-4xl">{{ totalUnit }}</div>
        </el-card>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
const totalUnit = ref(0);

const getTotalUnit = async () => {
    await window.axios.get("/dashboard/total-units").then((response) => {
        totalUnit.value = response.data.data;
    });
};

onMounted(async () => {
    await getTotalUnit();
});
</script>
