<template>
    <div class="w-full">
        <el-card>
            <template #header>
                <div class="card-header flex justify-between">
                    <div>Top 10 user login</div>
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
            <el-table :data="topTenUserLogin" style="width: 100%">
                <el-table-column prop="name" label="Name"></el-table-column>
                <el-table-column
                    prop="login_histories_count"
                    label="Total Login"
                ></el-table-column>
            </el-table>
        </el-card>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
const topTenUserLogin = ref([]);
const filterDate = ref(null);

const getTopTenUserLogin = async () => {
    let params = {};
    if (filterDate.value) {
        params = {
            start_date: filterDate.value[0],
            end_date: filterDate.value[1],
        };
    }
    await window.axios
        .get("/dashboard/top-ten-user-login", { params })
        .then((response) => {
            topTenUserLogin.value = response.data.data;
        });
};

watch(filterDate, async () => {
    await getTopTenUserLogin();
});

onMounted(async () => {
    await getTopTenUserLogin();
});
</script>
