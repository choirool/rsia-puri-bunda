<template>
    <div class="flex justify-end items-center mb-4">
        <el-button type="primary" @click="dialogFormVisible = true">
            Add
        </el-button>
    </div>
    <el-dialog
        v-model="dialogFormVisible"
        :title="props.unit ? `Update unit` : `Create unit`"
        @closed="dialodClosed"
        width="30%"
    >
        <el-form :model="form" label-width="auto" style="max-width: 600px">
            <el-form-item label="Unit name">
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
                        v-if="props.unit"
                        type="primary"
                        @click="updateUnit"
                        :loading="loading"
                    >
                        Update
                    </el-button>
                    <el-button
                        v-else
                        type="primary"
                        @click="createUnit"
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

const props = defineProps(["unit"]);
const dialogFormVisible = ref(false);
const loading = ref(false);
const errors = ref([]);
const emits = defineEmits(["unitCreated"]);
const form = reactive({
    name: "",
});

const createUnit = async () => {
    loading.value = true;

    try {
        const response = await window.axios.post("/units", form);

        if (response.status === 201) {
            dialogFormVisible.value = false;
            errors.value = [];
            form.name = "";
            ElMessage.success("Unit created successfully");
            emits("unitCreated");
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

const updateUnit = async () => {
    loading.value = true;

    try {
        const response = await window.axios.put(
            `/units/${props.unit.id}`,
            form
        );

        if (response.status === 200) {
            dialogFormVisible.value = false;
            errors.value = [];
            form.name = "";
            ElMessage.success("Unit updated successfully");
            emits("unitCreated");
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
        form.name = props.unit.name;
    });
};

const dialodClosed = () => {
    form.name = "";
    errors.value = [];
    props.unit = null;
};

defineExpose({
    openDialog,
});
</script>
