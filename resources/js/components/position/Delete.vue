<template>
    <el-popconfirm
        confirm-button-text="Yes"
        cancel-button-text="No"
        :icon="InfoFilled"
        icon-color="#626AEF"
        title="Are you sure to delete this?"
        @confirm="deletePosition"
    >
        <template #reference>
            <el-button type="danger">Delete</el-button>
        </template>
    </el-popconfirm>
</template>

<script setup>
import { ElMessage } from "element-plus";
import { ref, defineEmits } from "vue";

const loading = ref(false);
const props = defineProps(["position"]);
const emits = defineEmits(["positionDeleted"]);

const deletePosition = async () => {
    loading.value = true;

    try {
        const response = await window.axios.delete(
            `/positions/${props.position.id}`
        );

        if (response.status === 204) {
            ElMessage.success("Positions deleted successfully");
            emits("positionDeleted");
        }
    } catch (error) {
        console.error("Error deleting unit:", error);
        ElMessage.error("An unexpected error occurred");
    } finally {
        loading.value = false;
    }
};
</script>
