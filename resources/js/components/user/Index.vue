<template>
    <div>
        <Form @userCreated="getUsers" :user="selectedUser" ref="userForm" />
        <el-table :data="users" style="width: 100%" v-loading="loading">
            <el-table-column prop="id" label="ID" width="50" />
            <el-table-column prop="name" label="Name" />
            <el-table-column prop="email" label="Email" />
            <el-table-column prop="username" label="Username" />
            <el-table-column prop="joining_date" label="Join Date" />
            <el-table-column prop="unit.name" label="Unit" />
            <el-table-column label="Jabatan">
                <template #default="scope">
                    <span
                        v-for="position in scope.row.positions"
                        :key="position.id"
                    >
                        {{ position.name }}
                    </span>
                </template>
            </el-table-column>
            <el-table-column label="Action" width="150">
                <template #default="scope">
                    <div class="flex justify-center">
                        <el-button
                            size="mini"
                            type="primary"
                            @click="
                                selectedUser = scope.row;
                                $refs.userForm.openDialog();
                            "
                        >
                            Edit
                        </el-button>
                        <Delete :user="scope.row" @userDeleted="getUsers" />
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

const users = ref([]);
const selectedUser = ref(null);
const loading = ref(false);
const pagination = reactive({
    currentPage: 1,
    pageSize: 10,
    total: 0,
});

const handleSizeChange = (val) => {
    pagination.pageSize = val;
    getUsers();
};

const handleCurrentChange = (val) => {
    pagination.currentPage = val;
    getUsers();
};

const getUsers = async () => {
    await axios
        .get("/users", {
            params: {
                page: pagination.currentPage,
                per_page: pagination.pageSize,
            },
        })
        .then((response) => {
            const { data } = response.data;
            users.value = data;

            pagination.total = response.data.total;
            pagination.pageSize = response.data.per_page;
            pagination.currentPage = response.data.current_page;
        });

    loading.value = false;
};

onMounted(() => {
    getUsers();
});
</script>
