<template>
    <div class="w-full">
        <el-card>
            <template #header>
                <div class="card-header">
                    <span>Total Position</span>
                </div>
            </template>
            <div class="text-center text-4xl">{{ totalPosition }}</div>
        </el-card>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
const totalPosition = ref(0);

const getTotalPosition = async () => {
    await axios.get("/dashboard/total-positions").then((response) => {
        totalPosition.value = response.data.data;
    });
};

onMounted(async () => {
    await getTotalPosition();
});
</script>
