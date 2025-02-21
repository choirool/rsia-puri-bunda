<template>
    <div class="flex justify-end items-center mb-4">
        <el-button type="primary" @click="dialogFormVisible = true">
            Add
        </el-button>
    </div>
    <el-dialog
        v-model="dialogFormVisible"
        :title="props.position ? `Update position` : `Create position`"
        @closed="dialodClosed"
        width="30%"
    >
        <el-form :model="form" label-width="auto" style="max-width: 600px">
            <el-form-item label="Position name">
                <el-input v-model="form.name" />
                <span
                    class="text-red-600"
                    v-if="errors.name"
                    v-text="errors.name[0]"
                ></span>
            </el-form-item>
            <div class="flex justify-end">
                <el-form-item>
                    <el-button
                        v-if="props.position"
                        type="primary"
                        @click="updatePosition"
                        :loading="loading"
                    >
                        Update
                    </el-button>
                    <el-button
                        v-else
                        type="primary"
                        @click="createPosition"
                        :loading="loading"
                    >
                        Create
                    </el-button>
                    <el-button @click="dialogFormVisible = false">
                        Cancel
                    </el-button>
                </el-form-item>
            </div>
        </el-form>
    </el-dialog>
</template>

<script setup>
import { ElMessage } from "element-plus";
import { ref, reactive, nextTick } from "vue";

const props = defineProps(["position"]);
const dialogFormVisible = ref(false);
const loading = ref(false);
const errors = ref([]);
const emits = defineEmits(["positionCreated"]);
const form = reactive({
    name: "",
});

const createPosition = async () => {
    loading.value = true;

    try {
        const response = await axios.post("/positions", form);

        if (response.status === 201) {
            dialogFormVisible.value = false;
            errors.value = [];
            form.name = "";
            ElMessage.success("Unit created successfully");
            emits("positionCreated");
        }
    } catch (error) {
        console.error("Error submitting form:", error);
        errors.value = error.response?.data?.errors || [
            "An unexpected error occurred",
        ];
    } finally {
        loading.value = false;
    }
};

const updatePosition = async () => {
    loading.value = true;

    try {
        const response = await axios.put(
            `/positions/${props.position.id}`,
            form
        );

        if (response.status === 200) {
            dialogFormVisible.value = false;
            errors.value = [];
            form.name = "";
            ElMessage.success("Position updated successfully");
            emits("positionCreated");
        }
    } catch (error) {
        console.error("Error submitting form:", error);
        errors.value = error.response?.data?.errors || [
            "An unexpected error occurred",
        ];
    } finally {
        loading.value = false;
    }
};

const openDialog = () => {
    nextTick(() => {
        dialogFormVisible.value = true;
        form.name = props.position.name;
    });
};

const dialodClosed = () => {
    form.name = "";
    errors.value = [];
    props.position = null;
};

defineExpose({
    openDialog,
});
</script>
