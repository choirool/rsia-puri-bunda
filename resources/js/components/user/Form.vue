<template>
    <div class="flex justify-end items-center mb-4">
        <el-button type="primary" @click="dialogFormVisible = true">
            Add
        </el-button>
    </div>
    <el-dialog
        v-model="dialogFormVisible"
        :title="props.position ? `Update user` : `Create user`"
        @closed="dialogClosed"
        @open="dialogOpened"
        width="60%"
    >
        <el-form :model="form" label-width="auto">
            <el-form-item label="Name">
                <el-input v-model="form.name" />
                <span
                    class="text-red-500"
                    v-if="errors.name"
                    v-text="errors.name[0]"
                ></span>
            </el-form-item>
            <el-form-item label="Position">
                <el-select
                    v-model="form.positions"
                    placeholder="Select position"
                    multiple
                    allow-create
                    filterable
                    remote-show-suffix
                    remote
                    :remote-method="getPositions"
                >
                    <el-option
                        v-for="position in positions"
                        :key="position.id"
                        :label="position.name"
                        :value="position.id"
                    ></el-option>
                </el-select>
                <span
                    class="text-red-500"
                    v-if="errors.positions"
                    v-text="errors.positions[0]"
                ></span>
            </el-form-item>
            <el-form-item label="Unit">
                <el-select
                    v-model="form.unit"
                    placeholder="Select unit"
                    allow-create
                    filterable
                    remote-show-suffix
                    remote
                    :remote-method="getUnits"
                >
                    <el-option
                        v-for="unit in units"
                        :key="unit.id"
                        :label="unit.name"
                        :value="unit.id"
                    ></el-option>
                </el-select>
                <span
                    class="text-red-500"
                    v-if="errors.name"
                    v-text="errors.name[0]"
                ></span>
            </el-form-item>
            <el-form-item label="Joining Date">
                <el-date-picker
                    v-model="form.joining_date"
                    type="date"
                    placeholder="Select date"
                    value-format="YYYY-MM-DD"
                    format="DD MMM YYYY"
                ></el-date-picker>
                <span
                    class="text-red-500"
                    v-if="errors.joining_date"
                    v-text="errors.joining_date[0]"
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

const props = defineProps(["user"]);
const dialogFormVisible = ref(false);
const loading = ref(false);
const errors = ref([]);
const emits = defineEmits(["positionCreated"]);
const form = reactive({
    name: "",
    positions: [],
    unit: "",
    joining_date: "",
});
const positions = ref([]);
const units = ref([]);

const getPositions = async (query) => {
    try {
        const { data } = await axios.get(
            `/positions?search=${query}&pagination=0`
        );
        positions.value = data;
    } catch (error) {
        console.log(error);
    }
};

const getUnits = async (query) => {
    try {
        const { data } = await axios.get(`/units?search=${query}&pagination=0`);
        units.value = data;
    } catch (error) {
        console.log(error);
    }
};

const openDialog = () => {
    nextTick(() => {
        dialogFormVisible.value = true;
        form.name = props.user.name;
    });
};

const dialogClosed = () => {
    form.name = "";
    form.positions = [];
    form.unit = "";
    form.joining_date = "";
    errors.value = [];
    props.user = null;
};

const dialogOpened = async () => {
    await getPositions("");
    await getUnits("");
};

defineExpose({
    openDialog,
});
</script>
