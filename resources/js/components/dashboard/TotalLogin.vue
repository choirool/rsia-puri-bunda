<template>
    <div class="w-full">
        <el-card>
            <template #header>
                <div class="card-header flex justify-between">
                    <div>Total Login</div>
                    <div>
                        <el-date-picker
                            v-model="filterDate"
                            type="daterange"
                            range-separator="To"
                            start-placeholder="Start date"
                            end-placeholder="End date"
                            value-format="YYYY-MM-DD"
                            format="YYYY-MM-DD"
                            clearable
                        />
                    </div>
                </div>
            </template>
            <div class="text-center text-4xl">{{ totalLogin }}</div>
        </el-card>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
const totalLogin = ref(0);
const filterDate = ref(null);

const getTotalLogin = async () => {
    let params = {};
    if (filterDate.value) {
        params = {
            start_date: filterDate.value[0],
            end_date: filterDate.value[1],
        };
    }

    await window.axios
        .get("/dashboard/total-login-history", { params })
        .then((response) => {
            totalLogin.value = response.data.data;
        });
};

watch(filterDate, async () => {
    await getTotalLogin();
});

onMounted(async () => {
    await getTotalLogin();
});
</script>
