<template>
    <el-popconfirm
        confirm-button-text="Yes"
        cancel-button-text="No"
        :icon="InfoFilled"
        icon-color="#626AEF"
        title="Are you sure to delete this?"
        @confirm="deleteUser"
    >
        <template #reference>
            <el-button type="danger">Delete</el-button>
        </template>
    </el-popconfirm>
</template>

<script setup>
import { ElMessage } from "element-plus";
import { ref } from "vue";

const loading = ref(false);
const props = defineProps(["user"]);
const emits = defineEmits(["userDeleted"]);

const deleteUser = async () => {
    loading.value = true;

    try {
        const response = await window.axios.delete(`/users/${props.user.id}`);

        if (response.status === 204) {
            ElMessage.success("User deleted successfully");
            emits("userDeleted");
        }
    } catch (error) {
        console.error("Error deleting unit:", error);
        ElMessage.error("An unexpected error occurred");
    } finally {
        loading.value = false;
    }
};
</script>
