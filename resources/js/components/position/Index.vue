<template>
    <div>
        <Form
            @positionCreated="getPositions"
            :position="selectedPosition"
            ref="positionForm"
        />
        <el-table :data="positions" style="width: 100%" v-loading="loading">
            <el-table-column prop="id" label="ID" width="50" />
            <el-table-column prop="name" label="Name" />
            <el-table-column label="Action" width="150">
                <template #default="scope">
                    <div class="flex justify-center">
                        <el-button
                            size="mini"
                            type="primary"
                            @click="
                                selectedPosition = scope.row;
                                $refs.positionForm.openDialog();
                            "
                        >
                            Edit
                        </el-button>
                        <Delete
                            :position="scope.row"
                            @positionDeleted="getPositions"
                        />
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <div class="mt-4">
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="pagination.currentPage"
                :page-sizes="[10, 20, 30, 40]"
                :page-size="pagination.pageSize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="pagination.total"
            ></el-pagination>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, reactive, defineAsyncComponent } from "vue";
const Form = defineAsyncComponent(() => import("./Form.vue"));
const Delete = defineAsyncComponent(() => import("./Delete.vue"));

const positions = ref([]);
const selectedPosition = ref(null);
const loading = ref(false);
const pagination = reactive({
    currentPage: 1,
    pageSize: 10,
    total: 0,
});

const handleSizeChange = (val) => {
    pagination.pageSize = val;
    getPositions();
};

const handleCurrentChange = (val) => {
    pagination.currentPage = val;
    getPositions();
};

const getPositions = async () => {
    await window.axios
        .get("/positions", {
            params: {
                page: pagination.currentPage,
                per_page: pagination.pageSize,
            },
        })
        .then((response) => {
            const { data } = response.data;
            positions.value = data;

            pagination.total = response.data.total;
            pagination.pageSize = response.data.per_page;
            pagination.currentPage = response.data.current_page;
        });

    loading.value = false;
};

onMounted(() => {
    getPositions();
});
</script>
